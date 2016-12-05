<?php namespace App\models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use DB;

/**
 * Class socialGalleryPostModel
 * @package App\models
 */
class socialGalleryPostModel extends Model  {

    /**
     * @var string
     */
    protected $table = 'social_gallery_post';
    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function productPost()
    {
        return $this->belongsTo('App\models\socialProductPostModel', 'social_product_post_id');
    }

    /**
     * @param $socialProductPostId
     * @param $galleryId
     * @param $image
     * @param $caption
     * @param $ref
     * @return socialGalleryPostModel
     */
    public static function addItem($socialProductPostId, $galleryId, $image, $caption, $ref){
        $socialGalleryPost = new socialGalleryPostModel();
        $socialGalleryPost->social_product_post_id = $socialProductPostId;
        $socialGalleryPost->gallery_id = $galleryId;
        $socialGalleryPost->image = $image;
        $socialGalleryPost->caption = $caption;
        $socialGalleryPost->ref = $ref;

        $socialGalleryPost->save();

        return $socialGalleryPost;
    }

    /**
     * @param $id
     * @return \Illuminate\Support\Collection|null|static
     */
    public function getById($id){
        return $this->find($id);
    }

    /**
     * @param $id
     * @param $data
     * @return mixed
     */
    public function updateItem($id, $data){
        return $this->where('id', $id)->update($data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteItem($id){

        return $this->where('id', $id)->delete();
    }


}
