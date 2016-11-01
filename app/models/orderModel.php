<?php namespace App\models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Kacana\DataTables;
use Carbon\Carbon;

/**
 * Class orderModel
 * @package App\models
 */
class orderModel extends Model  {

    /**
     * @var string
     */
    protected $table = 'orders';

    /**
     * @var bool
     */
    public $timestamps = false;


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderDetail()
    {
        return $this->hasMany('App\models\orderDetailModel', 'order_id', 'id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\models\User', 'user_id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function addressReceive()
    {
        return $this->belongsTo('App\models\addressReceiveModel', 'address_id');
    }


    /**
     * @param $item
     * @return orderModel
     */
    public function createItem($item){
        $object = new orderModel();
        foreach($item as $k=>$v){
            $object->{$k} = $v;
        }
        $object->created = date('Y-m-d H:i:s');
        $object->updated = date('Y-m-d H:i:s');
        $object->save();
        return $object;
    }

    /**
     * @param $id
     * @param $item
     */
    public function updateItem($id, $item){
        $object = $this->find($id);

        foreach($item as $k=>$v){
            $object->{$k} = $v;
        }

        $object->updated = date('Y-m-d H:i:s');
        $this->where('id', $id)->update($item);
    }

    /**
     * @param bool $userId
     * @return mixed
     */
    public function getListOrder($userId = false){
        $select =  $this->orderBy('id','desc');
        if($userId)
            $select = $select->where('user_id', $userId);
        $orders = $select->get();
        return $orders;
    }


    /**
     * @param $id
     * @return \Illuminate\Support\Collection|null|static
     */
    public function getById($id){
        return $this->find($id);
    }


    /**
     * @param $orderCode
     * @return mixed
     */
    public function getByOrderCode($orderCode){
        return $this->where('order_code', $orderCode)->first();
    }

    /**
     * @param $request
     * @param $columns
     * @return array
     */
    public function generateOrderTable($request, $columns){

        $datatables = new DataTables();

        $limit = $datatables::limit( $request, $columns );
        $order = $datatables::order( $request, $columns );
        $where = $datatables::filter( $request, $columns );

        // Main query to actually get the data
        $selectData = DB::table('orders')
            ->select($datatables::pluck($columns, 'db'))
            ->leftJoin('users', 'orders.user_id', '=', 'users.id')
            ->orderBy($order['field'], $order['dir'])
            ->skip($limit['offset'])
            ->take($limit['limit']);

        // Data set length
        $recordsFiltered = $selectLength = DB::table('orders')
            ->select($datatables::pluck($columns, 'db'))
            ->join('users', 'orders.user_id', '=', 'users.id');

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
    public function reportDetailTableOrder($request, $columns){

        $datatables = new DataTables();
        $type = $request['type'];
        $limit = $datatables::limit( $request, $columns );
        $order = $datatables::order( $request, $columns );
        $where = $datatables::filter( $request, $columns );
        $dateSelected = $request['dateSelected'];

        if($type == 'day')
            $typeWhere = DB::raw('DATE_FORMAT(kacana_orders.created, "%Y-%m-%d")');
        elseif($type == 'month') {
            $dateSelected = substr($dateSelected,0,7);
            $typeWhere =DB::raw('DATE_FORMAT(kacana_orders.created, "%Y-%m")');
        }
        elseif($type == 'year') {
            $dateSelected = substr($dateSelected,0,4);
            $typeWhere = DB::raw('DATE_FORMAT(kacana_orders.created, "%Y")');
        }
        // Main query to actually get the data
        $selectData = DB::table('orders')
            ->select($datatables::pluck($columns, 'db'))
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->orderBy($order['field'], $order['dir'])
            ->skip($limit['offset'])
            ->take($limit['limit'])
            ->where($typeWhere,'=',$dateSelected);

        // Data set length
        $recordsFiltered = $selectLength = DB::table('orders')
            ->select($datatables::pluck($columns, 'db'))
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->where($typeWhere,'=',$dateSelected);

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

    /**
     * @param bool $duration
     * @return mixed
     */
    public function getCountOrder($duration = false){
        $date = Carbon::now()->subDays($duration);
        if($duration === false)
            return $this->count();
        else
            return $this->where('created', '>=', $date)->count();
    }

    /**
     * @param $startTime
     * @param $endTime
     * @param string $type
     * @return mixed
     */
    public function reportOrder($startTime, $endTime, $type = 'date')
    {
        $orderReport =  $this->where('created', '>=', $startTime)
            ->where('created', '<=', $endTime);
        if($type == 'day')
            $orderReport->select('*', DB::raw('DATE_FORMAT(created, "%Y-%m-%d") as date'), (DB::raw('count(id) as item')))
                ->groupBy('date');
        elseif($type == 'month')
            $orderReport->select('*', DB::raw('DATE_FORMAT(created, "%Y-%m") as date'), (DB::raw('count(id) as item')))
                ->groupBy('date');
        elseif($type == 'year')
            $orderReport->select('*',DB::raw('DATE_FORMAT(created, "%Y") as date'), (DB::raw('count(id) as item')))
                ->groupBy('date');

        return $orderReport->get();
    }
}
