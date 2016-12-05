<?php namespace App\models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use DB;

/**
 * Class socialProductPostModel
 * @package App\models
 */
class socialProductPostModel extends Model  {

    /**
     * @var string
     */
    protected $table = 'social_product_post';
    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo('App\models\Product');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo('App\models\socialPostModel', 'social_post_id');
    }

    /**
     * @param $socialPostId
     * @param $productId
     * @return socialProductPostModel
     */
    public static function addItem($socialPostId, $productId){
        $socialProductPost = new socialProductPostModel();
        $socialProductPost->social_post_id = $socialPostId;
        $socialProductPost->product_id = $productId;

        $socialProductPost->save();

        return $socialProductPost;
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
