<?php namespace App\services;

use App\models\productModel;
use App\models\productPropertiesModel;
use App\models\productTagModel;
use App\models\tagModel;
use App\models\userProductLikeModel;
use Kacana\DataTables;
use Kacana\ViewGenerateHelper;
use Kacana\HtmlFixer;
use Cache;
use App\models\productGalleryModel;
use \Storage;
/**
 * Class productGalleryService
 * @package App\services
 */
class productGalleryService extends baseService {


    /**
     * @param $id
     * @param $imageName
     * @param $type
     * @return productGalleryModel
     */
    public function addProductImage($id, $imageName, $type){
        $productGallery = new productGalleryModel();
        $productModel = new productModel();
        $prefixPath = '/images/product/';
        $product = $productModel->getProductById($id, false);

        $thumbPath = '';
        $newThumbPath = '';
        $imageNameFinal = explode('.', $imageName);
        $typeImage = $imageNameFinal[count($imageNameFinal)-1];

        if($type == PRODUCT_IMAGE_TYPE_SLIDE)
        {
            $newThumbPath = $prefixPath.$product->name.' thumb '.crc32($imageName).'.'.$typeImage;
            $thumbPath = str_replace(PATH_PUBLIC, '', $this->createThumbnail(PATH_PUBLIC . $imageName, 80, 80, [255, 255, 255]));

            $this->uploadToS3($thumbPath, $newThumbPath);
        }
        $newImageName = $prefixPath.$product->name.' '.crc32($imageName).'.'.$typeImage;
        $return = $productGallery->addProductImage($id, $newImageName, $newThumbPath, $type);

        $this->uploadToS3($imageName, $newImageName);

        return $return;
    }

    public function deleteImage($id){
        $productGallery = new productGalleryModel();
        $gallery = $productGallery->getById($id);

        if($gallery->getOriginal('image'))
            $this->deleteFromS3($gallery->getOriginal('image'));
        if($gallery->getOriginal('thumb'))
            $this->deleteFromS3($gallery->getOriginal('thumb'));

        return $productGallery->deleteImage($id);
    }

    /**
     * @param $filepath
     * @param $thumbnail_width
     * @param $thumbnail_height
     * @param bool $background
     * @return string
     */
    function createThumbnail($filepath, $thumbnail_width, $thumbnail_height, $background=false) {
        if(!filesize($filepath))
            return false;

        list($original_width, $original_height, $original_type) = getimagesize($filepath);
        if ($original_width > $original_height) {
            $new_width = $thumbnail_width;
            $new_height = intval($original_height * $new_width / $original_width);
        } else {
            $new_height = $thumbnail_height;
            $new_width = intval($original_width * $new_height / $original_height);
        }
        $dest_x = intval(($thumbnail_width - $new_width) / 2);
        $dest_y = intval(($thumbnail_height - $new_height) / 2);
        if ($original_type === 1) {
            $imgt = "ImageGIF";
            $imgcreatefrom = "ImageCreateFromGIF";
        } else if ($original_type === 2) {
            $imgt = "ImageJPEG";
            $imgcreatefrom = "ImageCreateFromJPEG";
        } else if ($original_type === 3) {
            $imgt = "ImagePNG";
            $imgcreatefrom = "ImageCreateFromPNG";
        } else {
            return false;
        }
        $old_image = $imgcreatefrom($filepath);
        $new_image = imagecreatetruecolor($thumbnail_width, $thumbnail_height); // creates new image, but with a black background
        // figuring out the color for the background
        if(is_array($background) && count($background) === 3) {
            list($red, $green, $blue) = $background;
            $color = imagecolorallocate($new_image, $red, $green, $blue);
            imagefill($new_image, 0, 0, $color);
            // apply transparent background only if is a png image
        } else if($background === 'transparent' && $original_type === 3) {
            imagesavealpha($new_image, TRUE);
            $color = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
            imagefill($new_image, 0, 0, $color);
        }
        imagecopyresampled($new_image, $old_image, $dest_x, $dest_y, 0, 0, $new_width, $new_height, $original_width, $original_height);
        $slicePath = explode('.',$filepath);
        $thumbpath = '';

        for($i = 0; $i < (count($slicePath)-2); $i++)
        {
            $thumbpath .=$slicePath[$i].'.';
        }
        $thumbpath .= $slicePath[count($slicePath)-2].'_thumb.'.$slicePath[count($slicePath)-1];

        $imgt($new_image, $thumbpath);
        if(file_exists($thumbpath))
            return $thumbpath;
    }

    /**
     * @param $path
     * @param $newPath
     * @return bool
     */
    public function uploadToS3($path, $newPath = false){
        if(Storage::disk('local')->exists($path))
        {
            $fileContent = Storage::disk('local')->get($path);

            if($newPath)
                Storage::put($newPath, $fileContent);
            else
                Storage::put($path, $fileContent);

            Storage::disk('local')->delete($path);
            return true;
        }
        else
            return false;
    }

    public function deleteFromS3($path)
    {
        if(Storage::exists($path))
            return Storage::delete($path);
        else
            return false;
    }
}