<?php namespace App\services;

use App\Http\Requests\Request;
use App\models\blogCommentModel;
use App\models\blogPostGalleryModel;
use App\models\blogPostModel;
use App\models\blogPostTagModel;
use App\models\blogPostViewModel;
use App\models\productModel;
use App\models\productPropertiesModel;
use App\models\productTagModel;
use App\models\productViewModel;
use App\models\tagModel;
use App\models\User;
use App\models\userProductLikeModel;
use App\models\userSocialModel;
use Kacana\Client\KPusher;
use Kacana\DataTables;
use Kacana\Util;
use Kacana\ViewGenerateHelper;
use Kacana\HtmlFixer;
use Cache;
use App\models\productGalleryModel;
use \Storage;
use Carbon\Carbon;

/**
 * Class blogService
 * @package App\services
 */
class blogService {

    /**
     * @var blogCommentModel
     */
    private $_blogComment;

    /**
     * @var blogPostModel
     */
    private $_blogPost;

    private $_blogPostView;

    /**
     * blogService constructor.
     */
    public function __construct()
    {
        $this->_blogComment = new blogCommentModel();
        $this->_blogPost = new blogPostModel();
        $this->_blogPostView = new blogPostViewModel();
    }

    public function createPost($title, $tagId, $userId){
        return $this->_blogPost->createItem($title, $tagId, $userId);
    }

    public function createComment(){
        return $this->_blogComment->createItem();
    }

    public function generatePostTable($request){
        $blogPostModel = new blogPostModel();
        $datatables = new DataTables();
        $viewHelper = new ViewGenerateHelper();

        $columns = array(
            array( 'db' => 'blog_posts.id', 'dt' => 0 ),
            array( 'db' => 'blog_posts.title', 'dt' => 1 ),
            array( 'db' => 'users.name AS author_name', 'dt' => 2 ),
            array( 'db' => 'tags.name', 'dt' => 3 ),
            array( 'db' => 'blog_posts.tag_id', 'dt' => 4 ),
            array( 'db' => 'blog_posts.status', 'dt' => 5 ),
            array( 'db' => 'blog_posts.created_at', 'dt' => 6 ),
            array( 'db' => 'blog_posts.updated_at', 'dt' => 7 )
        );

        $return = $blogPostModel->generatePostTable($request, $columns);
        $optionStatus = [KACANA_BLOG_POST_STATUS_ACTIVE, KACANA_BLOG_POST_STATUS_INACTIVE];

        if(count($return['data'])) {
            foreach ($return['data'] as &$res) {
                $res->status = $viewHelper->dropdownView('blog_posts', $res->id, $res->status, 'status', $optionStatus);
                $res->tag_id = $res->count_item_blog_comment;
            }
        }

        $return['data'] = $datatables::data_output( $columns, $return['data'] );

        return $return;
    }

    public function generateCommentTable($request, $postId){
        $blogCommentModel = new blogCommentModel();
        $datatables = new DataTables();
        $viewHelper = new ViewGenerateHelper();

        $columns = array(
            array( 'db' => 'blog_comments.id', 'dt' => 0 ),
            array( 'db' => 'users.name AS author_name', 'dt' => 1 ),
            array( 'db' => 'blog_comments.body', 'dt' => 2 ),
            array( 'db' => 'blog_comments.status', 'dt' => 3 ),
            array( 'db' => 'blog_comments.created_at', 'dt' => 4 ),
            array( 'db' => 'blog_comments.updated_at', 'dt' => 5 )
        );

        $return = $blogCommentModel->generateCommentTable($request, $columns, $postId);
        $optionStatus = [KACANA_BLOG_COMMENT_STATUS_ACTIVE, KACANA_BLOG_COMMENT_STATUS_INACTIVE];

        if(count($return['data'])) {
            foreach ($return['data'] as &$res) {
                $res->status = $viewHelper->dropdownView('blog_comments', $res->id, $res->status, 'status', $optionStatus);
            }
        }

        $return['data'] = $datatables::data_output( $columns, $return['data'] );

        return $return;
    }

    public function getPostById($postId){
        $post = $this->_blogPost->getItemById($postId);

        return $post;
    }

    public function updateBlogPost($id, $title, $tagId, $status, $body, $postTags)
    {
        $this->updateTagPost($postTags, $id);
        $this->trimImageDesc($body, $id);
        return $this->_blogPost->updateItem($id, $title, $tagId, $status, $body);
    }

    /**
     * @param $description
     * @param $id
     */
    public function trimImageDesc($description, $id){
        $postGallery = new blogPostGalleryModel();

        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->strictErrorChecking = false;
        preg_match_all('/src="(.*?)"/', $description, $items);
        $images = $items[1];
        $postImageDesc = $postGallery->getImagesPostByPostId($id);

        foreach ($postImageDesc as $image)
        {
            if(!in_array($image->image, $images))
            {
                $this->deletePostImage($image->id);
            }
        }
    }

    public function deletePostImage($id){
        $postGallery = new blogPostGalleryModel();
        $productGalleryService = new productGalleryService();
        $gallery = $postGallery->getById($id);

        if($gallery->getOriginal('image'))
            $productGalleryService->deleteFromS3($gallery->getOriginal('image'));
        if($gallery->getOriginal('thumb'))
            $productGalleryService->deleteFromS3($gallery->getOriginal('thumb'));

        return $postGallery->deleteImage($id);
    }

    public function updateTagPost($postTags, $postId, $type = 1){
        $blogPostTagModel = new blogPostTagModel();
        $blogPostTagModel->removeItem($postId, $type);
        if($postTags)
        {
            foreach($postTags as $tagId)
            {
                $blogPostTagModel->createItem($tagId, $postId, $type);
            }
        }
    }

    public function updatePostMainImage($postId, $imageName){

        $productGalleryService = new productGalleryService();
        $prefixPath = '/images/blog/';
        $post = $this->_blogPost->getItemById($postId);
        $newImageName = $imageName;

        if($post->getOriginal('image'))
            $productGalleryService->deleteFromS3($post->getOriginal('image'));

        if($imageName)
        {
            $imageNameFinal = explode('.', $imageName);
            $typeImage = $imageNameFinal[count($imageNameFinal)-1];
            $newImageName = $prefixPath.str_slug($post->title).' '.time().'.'.$typeImage;

            $productGalleryService->uploadToS3($imageName, $newImageName);
        }


        return $this->_blogPost->updateImage($postId, $newImageName);
    }

    public function addPostImage($id, $imageName){
        $blogPostGallery = new blogPostGalleryModel();
        $productGalleryService = new productGalleryService();
        $prefixPath = '/images/blog/';
        $post = $this->_blogPost->getItemById($id);

        $thumbPath = '';
        $newThumbPath = '';
        $imageNameFinal = explode('.', $imageName);
        $typeImage = $imageNameFinal[count($imageNameFinal)-1];

        $newImageName = $prefixPath.$post->title.' '.crc32($imageName).'.'.$typeImage;
        $return = $blogPostGallery->addPostImage($id, $newImageName, $newThumbPath);

        $productGalleryService->uploadToS3($imageName, $newImageName);

        return $return;
    }

    public function getListPost($limit, $offset, $tagId = false, $exclude = false){
        return $this->_blogPost->getListPost($limit, $offset, $tagId, $exclude);
    }

    public function getALlPostAvailable(){
        return $this->_blogPost->getALlPostAvailable();
    }

    public function trackUserPostView($postId, $ip){
        $this->_blogPostView->createItem(['post_id' => $postId, 'ip' => $ip]);
    }

}



?>