<?php namespace App\services;

use App\Commands\PostToSocial;
use App\models\productModel;
use App\models\socialGalleryPostModel;
use App\models\socialProductPostModel;
use App\models\userBusinessSocialModel;
use Kacana\Util;
use App\models\productGalleryModel;
use App\models\socialPostModel;
use Queue;
/**
 * Class productService
 * @package App\services
 */
class socialService {

    public function superPostToSocial($userId, $socials, $products, $desc){
        $productModel = new productModel();
        $productGalleryModel = new productGalleryModel();
        $socialPostModel = new socialPostModel();
        $socialProductPostModel = new socialProductPostModel();
        $socialGalleryPostModel = new socialGalleryPostModel();

        $bootType = SOCIAL_BOOT_TYPE_SUPER;

        if(count($products) == 1)
            $bootType = SOCIAL_BOOT_TYPE_NORMAL;

        foreach ($socials as $social){
            $socialPost = $socialPostModel->addItem($userId, $social['socialId'], $social['type'], $bootType, $this->trimDescPostToFacebook($desc), '');

            $arrayImage = [];
            foreach ($products as $product)
            {
                if($this->isValidProduct($userId, $product['productId']))
                {
                    $socialProductPost = $socialProductPostModel->addItem($socialPost->id, $product['productId']);

                    $productImageIds = $product['images'];
                    for($i = 0; $i < count($productImageIds); $i++)
                    {
                        $urlImage = '';

                        if($productImageIds[$i] == 'image')
                        {
                            $productTemp = $productModel->getProductById($product['productId'], false);
                            $urlImage = $productTemp->image;
                        }
                        else{
                            $gallery = $productGalleryModel->getById($productImageIds[$i], $product['productId']);
                            $urlImage = $gallery->image;
                        }
                        $socialGalleryPost = $socialGalleryPostModel->addItem($socialProductPost->id, $productImageIds[$i], $urlImage, $this->trimDescPostToFacebook($product['caption']), '');

                        array_push($arrayImage,
                            ['socialGalleryPostId'  =>  $socialGalleryPost->id,
                             'url'                  =>  $this->trimImageLinkForSocial($urlImage),
                             'caption'              =>  $this->trimDescPostToFacebook($product['caption'])
                            ]);
                    }
                }
            }

            $job = [
                "socialPostId" => $socialPost->id,
                "userId" => $userId,
                "social" => $social,
                "images" => $arrayImage,
                "desc" => $this->trimDescPostToFacebook($desc)
                ];

            // push process to post to queue and response for user is processing
            Queue::push(new PostToSocial(base64_encode(json_encode($job))));
        }

        return true;
    }

    public function postToSocial($socialPostId, $userId, $social, $images, $descPost){
        $util = new Util();
        $socialPostModel = new socialPostModel();
        $socialGalleryPostModel = new socialGalleryPostModel();

        $userBusinessSocial = new userBusinessSocialModel();

        if(!$this->isValidSocial($userId, $social->type, $social->socialId))
            throw new \Exception('BAD Social ID');

        $socialAccount = $userBusinessSocial->getItem($userId, $social->type, $social->socialId);

        $facebook = $util->initFacebook();
        $facebook->setDefaultAccessToken($socialAccount->token);
        $arrayFbMedia = [];

        foreach ($images as $image)
        {
            $imagePost = $facebook->postPhoto($image->url, $image->caption);
            $socialGalleryPostModel->updateItem($image->socialGalleryPostId, ['ref' => $imagePost['id']]);
            array_push($arrayFbMedia, $imagePost);
        }

        $socialPost = $facebook->postFeed($arrayFbMedia, $descPost);
        $socialPostModel->updateItem($socialPostId, ['ref' => $socialPost['id']]);

        return $socialPost;
    }

    /**
     * @param $userId
     * @param $type
     * @param $socialId
     * @return bool
     */
    public function isValidSocial($userId, $type, $socialId){
        $userBusinessSocial = new userBusinessSocialModel();

        $item = $userBusinessSocial->getItem($userId, $type, $socialId);

        if($item)
            return true;

        return false;
    }

    /**
     * @param $userId
     * @param $productId
     * @return bool
     */
    public function isValidProduct($userId, $productId){
        $productModel = new productModel();

        $product = $productModel->getProductById($productId, false);

        if($product->boot_priority > 0)
            return true;
        else
            return false;
    }

    public function trimImageLinkForSocial($image)
    {
        return 'http:'.str_replace(' ', '%20',$image);
    }

    public function trimDescPostToFacebook($desc){
        return str_replace('<br>', PHP_EOL, $desc);
    }
}