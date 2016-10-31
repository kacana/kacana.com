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

    public function reportDetailTableProductLike($request, $columns){

        $datatables = new DataTables();
        $type = $request['type'];
        $limit = $datatables::limit( $request, $columns );
        $order = $datatables::order( $request, $columns );
        $where = $datatables::filter( $request, $columns );
        $dateSelected = $request['dateSelected'];

        if($type == 'day')
            $typeWhere = DB::raw('DATE_FORMAT(kacana_user_product_like.created_at, "%Y-%m-%d")');
        elseif($type == 'month') {
            $dateSelected = substr($dateSelected,0,7);
            $typeWhere =DB::raw('DATE_FORMAT(kacana_user_product_like.created_at, "%Y-%m")');
        }
        elseif($type == 'year') {
            $dateSelected = substr($dateSelected,0,4);
            $typeWhere = DB::raw('DATE_FORMAT(kacana_user_product_like.created_at, "%Y")');
        }
        // Main query to actually get the data
        $selectData = DB::table('user_product_like')
            ->select($datatables::pluck($columns, 'db'))
            ->leftjoin('users', 'user_product_like.user_id', '=', 'users.id')
            ->orderBy($order['field'], $order['dir'])
            ->skip($limit['offset'])
            ->take($limit['limit'])
            ->where($typeWhere,'=',$dateSelected);

        // Data set length
        $recordsFiltered = $selectLength = DB::table('user_product_like')
            ->select($datatables::pluck($columns, 'db'))
            ->join('users', 'user_product_like.user_id', '=', 'users.id');

        if($where){
            $selectData->whereRaw($where);
            $recordsFiltered->whereRaw($where);
        }

        /*
         * Output
         */
        return array(
            "draw"            => intval( $request['draw'] ),
            "recordsTotal"    => intval( $selectLength->count() ),
            "recordsFiltered" => intval( $recordsFiltered->count() ),
            "data"            => $selectData->get()
        );
    }
}
