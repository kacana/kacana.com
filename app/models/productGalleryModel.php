<?php namespace App\models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use DB;

class productGalleryModel extends Model  {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_gallery';
    public $timestamps = false;

    /**
     * Get the tags associated with product
     */
    public function product()
    {
        return $this->belongsTo('App\models\Product');
    }

    public function productProperties()
    {
        return $this->hasMany('App\models\productPropertiesModel', 'product_gallery_id');
    }

    public static function showImageColor($id)
    {
        return DB::table('product_gallery')->where('id', $id)->pluck('image');
    }

    public function getImageFromProductAndColor($pid, $cid){
        $gallery_id =  DB::table('product_color')->where(array('product_id'=>$pid, 'color_id'=>$cid))->pluck('gallery_id');
        return DB::table('product_gallery')->where('id', $gallery_id)->pluck('image');

    }

    public function getImagesProductByProductId($pid, $type = false)
    {
        $images =  $this->where('product_id',$pid)->orderBy('id','desc');

        if($type)
        {
            $images->where('type', $type);
        }

        return $images->get();
    }

    public static function addProductImage($productId, $nameImage, $thumb, $type = PRODUCT_IMAGE_TYPE_NORMAL){
        $productGallery = new productGalleryModel();
        $productGallery->product_id = $productId;
        $productGallery->image = $nameImage;
        $productGallery->thumb = $thumb;
        $productGallery->type = $type;
        $productGallery->save();

        return $productGallery;
    }

    public static function getImageById($id){
        $image =  DB::table('product_gallery')->where(array('id'=>$id))->first();
        return $image;
    }

    public function deleteImage($id){

        return $this->where('id', $id)->delete();
    }

    public function setPrimaryImage($id, $productId){
        $this->where('product_id', $productId)->where('type', PRODUCT_IMAGE_TYPE_MAIN)->update(['type' => PRODUCT_IMAGE_TYPE_NORMAL]);
        return $this->where('id', $id)->update(['type' => PRODUCT_IMAGE_TYPE_MAIN]);
    }

    public function setSlideImage($id){
        $image = $this->where('id', $id)->first();

        if($image->type == PRODUCT_IMAGE_TYPE_SLIDE){
            $this->where('id', $id)->update(['type' => PRODUCT_IMAGE_TYPE_NORMAL]);

        }
        else{
            $this->where('id', $id)->update(['type' => PRODUCT_IMAGE_TYPE_SLIDE]);
        }

        return $this->find($id);
    }

    public function getById($id){
        return $this->find($id);
    }

    public function updateThumb($id, $thumb){
        $item['thumb'] = $thumb;

        return $this->where('id', $id)->update($item);
    }

    public function getImageAttribute($value)
    {
        return AWS_CDN_URL.$value;
    }

    public function getThumbAttribute($value)
    {
        return AWS_CDN_URL.$value;
    }

}
