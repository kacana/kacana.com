<?php namespace App\models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use DB;

/**
 * Class socialPostModel
 * @package App\models
 */
class socialPostModel extends Model  {

    /**
     * @var string
     */
    protected $table = 'social_post';
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
    public function businessSocial()
    {
        return $this->belongsTo('App\models\userBusinessSocialModel');
    }

    /**
     * @param $userId
     * @param $socialId
     * @param $socialTypeId
     * @param $type
     * @param $desc
     * @param $ref
     * @return socialPostModel
     */
    public static function addItem($userId, $socialId, $socialTypeId, $type, $desc, $ref){
        $socialPost = new socialPostModel();
        $socialPost->user_id = $userId;
        $socialPost->social_id = $socialId;
        $socialPost->social_type_id = $socialTypeId;
        $socialPost->type = $type;
        $socialPost->desc = $desc;
        $socialPost->ref = $ref;
        $socialPost->save();

        return $socialPost;
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
