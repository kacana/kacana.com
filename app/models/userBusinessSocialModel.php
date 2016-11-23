<?php namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class orderModel
 * @package App\models
 */
class userBusinessSocialModel extends Model
{

    /**
     * @var string
     */
    protected $table = 'user_business_social';

    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * Get the user that owns the user address.
     */
    public function user()
    {
        return $this->belongsTo('App\models\User', 'user_id', 'id');
    }

    /**
     * @param $data
     * @return bool
     */
    public function createItem($data){

        $userBusinessSocial = new userBusinessSocialModel();

        $userBusinessSocial->social_id = $data['social_id'];
        $userBusinessSocial->user_id = $data['user_id'];
        $userBusinessSocial->email = $data['email'];
        $userBusinessSocial->name = $data['name'];
        $userBusinessSocial->type = $data['type'];
        $userBusinessSocial->token = $data['token'];
        $userBusinessSocial->token_expire = $data['token_expire'];
        $userBusinessSocial->image = $data['image'];
        $userBusinessSocial->status = $data['status'];

        return $userBusinessSocial->save();
    }

    /**
     * @param $userId
     * @param $item
     * @param $type
     * @param $socialId
     * @return mixed
     */
    function updateItem($userId, $type, $socialId, $item)
    {
        $this->where('user_id', $userId)
            ->where('type', $type)
            ->where('social_id', $socialId)
            ->update($item);

        return $this->where('user_id', $userId)
            ->where('type', $type)
            ->where('social_id', $socialId)
            ->first();
    }

    /**
     * @param $userId
     * @param $type
     * @param $socialId
     * @return mixed
     */
    public function removeItem($userId, $type, $socialId){
        return $this->where('user_id', $userId)
            ->where('type', $type)
            ->where('social_id', $socialId)
            ->delete();
    }

    /**
     * @param $userId
     * @param $type
     * @param $socialId
     * @return mixed
     */
    public function getItem($userId, $type, $socialId){
        return $this->where('user_id', $userId)
            ->where('type', $type)
            ->where('social_id', $socialId)
            ->first();
    }

    /**
     * @param $socialId
     * @param $type
     * @return mixed
     */
    public function getItemBySocialId($socialId, $type){
        return $this->where('social_id', $socialId)
            ->where('type', $type)
            ->first();
    }

    /**
     * @param $userId
     * @param $type
     * @param $status
     * @return mixed
     */
    public function getItemsByUserId($userId, $type = false, $status = KACANA_USER_BUSINESS_SOCIAL_STATUS_ACTIVE){
        $socialBusiness = $this->where('user_id', $userId);

        if($type)
            $socialBusiness->where('type', $type);

        if($status)
            $socialBusiness->where('status', $status);

        return $socialBusiness->get();
    }


}
