<?php namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class orderModel
 * @package App\models
 */
class userSocialModel extends Model
{

    /**
     * @var string
     */
    protected $table = 'user_social';

    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * @param $userId
     * @param $type
     * @param $token
     * @param $socialId
     * @return bool
     */
    public function createItem($userId, $type, $token, $socialId){
        $userSocial = new userSocialModel();
        $userSocial->user_id = $userId;
        $userSocial->type = $type;
        $userSocial->token = $token;
        $userSocial->social_id = $socialId;

        return $userSocial->save();
    }

    /**
     * @param $userId
     * @param $item
     * @param $type
     * @return mixed
     */
    function updateItem($userId, $type, $item)
    {
        $item['updated_at'] = date('Y-m-d H:i:s');
        $this->where('user_id', $userId)->where('type', $type)->update($item);
        return $this->where('user_id', $userId)->where('type', $type)->first();
    }

    /**
     * @param $userId
     * @param $type
     * @return mixed
     */
    public function removeItem($userId, $type){
        return $this->where('user_id', $userId)
            ->where('type', $type)
            ->delete();
    }

    /**
     * @param $userId
     * @param $type
     * @return mixed
     */
    public function getItem($userId, $type){
        return $this->where('user_id', $userId)
            ->where('type', $type)
            ->first();
    }


}
