<?php namespace App\models;

use Carbon\Carbon;
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

    public function countLike($duration = false){
        $date = Carbon::now()->subDays($duration);

        if($duration === false)
            return $this->count();
        else
            return $this->where('created_at', '>=', $date)->count();
    }

    public function reportUserProductLike($startTime, $endTime, $type = 'date')
    {
        $userProductLikeReport =  $this->where('created_at', '>=', $startTime)
            ->where('created_at', '<=', $endTime);
        if($type == 'day')
            $userProductLikeReport->select('*', DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as date'), (DB::raw('count(*) as item')))
                ->groupBy('date');
        elseif($type == 'month')
            $userProductLikeReport->select('*', DB::raw('DATE_FORMAT(created_at, "%Y-%m") as date'), (DB::raw('count(*) as item')))
                ->groupBy('date');
        elseif($type == 'year')
            $userProductLikeReport->select('*',DB::raw('DATE_FORMAT(created_at, "%Y") as date'), (DB::raw('count(*) as item')))
                ->groupBy('date');
        return $userProductLikeReport->get();
    }
}
