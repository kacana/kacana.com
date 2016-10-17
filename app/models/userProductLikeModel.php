<?php namespace App\models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Kacana\DataTables;

/**
 * Class orderModel
 * @package App\models
 */
class userProductLikeModel extends Model
{

    /**
     * @var string
     */
    protected $table = 'user_product_like';

    /**
     * @param $userId
     * @param $productId
     * @param $url
     * @return bool
     */
    public function createItem($userId, $productId, $url){
        $userProductLike = new userProductLikeModel();
        $userProductLike->user_id = $userId;
        $userProductLike->product_id = $productId;
        $userProductLike->product_url = $url;

        return $userProductLike->save();
    }

    /**
     * @param $userId
     * @param $productId
     * @return mixed
     */
    public function removeItem($userId, $productId){
        return $this->where('user_id', $userId)
            ->where('product_id', $productId)
            ->delete();
    }

    /**
     * @param $userId
     * @param $productId
     * @return mixed
     */
    public function getItem($userId, $productId){
        return $this->where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();
    }
}
