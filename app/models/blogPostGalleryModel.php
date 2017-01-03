<?php namespace App\models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use DB;

class blogPostGalleryModel extends Model  {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'blog_post_gallery';
    public $timestamps = false;

    public function getImagesPostByPostId($pid, $type = false)
    {
        $images =  $this->where('post_id',$pid)->orderBy('id','desc');

        if($type)
        {
            $images->where('type', $type);
        }

        return $images->get();
    }

    public static function addPostImage($postId, $nameImage, $thumb, $type = BLOG_IMAGE_TYPE_DESC){
        $postGallery = new blogPostGalleryModel();
        $postGallery->post_id = $postId;
        $postGallery->image = $nameImage;
        $postGallery->thumb = $thumb;
        $postGallery->type = $type;
        $postGallery->save();

        return $postGallery;
    }

    public static function getImageById($id){
        $image =  DB::table('blog_post_gallery')->where(array('id'=>$id))->first();
        return $image;
    }

    public function deleteImage($id){

        return $this->where('id', $id)->delete();
    }

    public function getById($id, $postId = 0){
        if($postId)
            return $this->where('post_id', $postId)->find($id);
        else
            return $this->find($id);
    }

    public function updateThumb($id, $thumb){
        $item['thumb'] = $thumb;

        return $this->where('id', $id)->update($item);
    }

    public function updateImage($id, $image){
        $item['image'] = $image;

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
