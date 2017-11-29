<?php namespace App\models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Kacana\DataTables;
use Carbon\Carbon;

/**
 * Class orderModel
 * @package App\models
 */
class orderModel extends Model
{

    /**
     * @var string
     */
    protected $table = 'orders';

    /**
     * @var bool
     */
    public $timestamps = true;


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

    public function orderType()
    {
        return $this->belongsTo('App\models\orderTypeModel', 'order_type');
    }


    /**
     * @param $item
     * @return orderModel
     */
    public function createItem($item)
    {
        $object = new orderModel();
        foreach ($item as $k => $v) {
            $object->{$k} = $v;
        }

        $object->save();
        return $object;
    }

    /**
     * @param $id
     * @param $item
     */
    public function updateItem($id, $item)
    {
        $object = $this->find($id);

        foreach ($item as $k => $v) {
            $object->{$k} = $v;
        }
        $this->where('id', $id)->update($item);
    }

    /**
     * @param bool $userId
     * @return mixed
     */
    public function getListOrder($userId = false)
    {
        $select = $this->orderBy('id', 'desc');
        if ($userId)
            $select = $select->where('user_id', $userId);
        $orders = $select->get();
        return $orders;
    }


    /**
     * @param $id
     * @return \Illuminate\Support\Collection|null|static
     */
    public function getById($id)
    {
        return $this->find($id);
    }

    public function getOrderByOrderCode($code)
    {
        return $this->where('order_code', $code)->orderBy('created_at', 'DESC')->first();
    }


    /**
     * @param $orderCode
     * @return mixed
     */
    public function getByOrderCode($orderCode)
    {
        return $this->where('order_code', $orderCode)->first();
    }

    /**
     * @param $request
     * @param $columns
     * @return array
     */
    public function generateOrderTable($request, $columns)
    {

        $datatables = new DataTables();

        $limit = $datatables::limit($request, $columns);
        $order = $datatables::order($request, $columns);
        $where = $datatables::filter($request, $columns);

        // Main query to actually get the data
        $selectData = DB::table('orders')
            ->select($datatables::pluck($columns, 'db'))
            ->leftJoin('users', 'orders.user_id', '=', 'users.id')
            ->leftJoin('address_receive', 'address_receive.id', '=', 'orders.address_id')
            ->leftJoin('order_types', 'order_types.id', '=', 'orders.order_type')
            ->orderBy($order['field'], $order['dir'])
            ->whereNotIn('orders.status', [KACANA_ORDER_PARTNER_STATUS_CANCEL, KACANA_ORDER_PARTNER_STATUS_NEW])
            ->skip($limit['offset'])
            ->take($limit['limit']);

        // Data set length
        $recordsFiltered = $selectLength = DB::table('orders')
            ->select($datatables::pluck($columns, 'db'))
            ->leftJoin('users', 'orders.user_id', '=', 'users.id')
            ->leftJoin('address_receive', 'address_receive.id', '=', 'orders.address_id')
            ->leftJoin('order_types', 'order_types.id', '=', 'orders.order_type');

        if ($where) {
            $selectData->whereRaw($where);
            $recordsFiltered->whereRaw($where);
        }
//echo $selectData->toSql();die;
        /*
         * Output
         */
        return array(
            "draw" => intval($request['draw']),
            "recordsTotal" => intval($selectLength->count()),
            "recordsFiltered" => intval($recordsFiltered->count()),
            "data" => $selectData->get()
        );
    }

    /**
     * @param $request
     * @param $columns
     * @return array
     */
    public function generateOrderTableByUserId($request, $columns, $userId)
    {

        $datatables = new DataTables();

        $limit = $datatables::limit($request, $columns);
        $order = $datatables::order($request, $columns);
        $where = $datatables::filter($request, $columns);

        // Main query to actually get the data
        $selectData = DB::table('orders')
            ->select($datatables::pluck($columns, 'db'))
            ->leftJoin('users', 'orders.user_id', '=', 'users.id')
            ->leftJoin('address_receive', 'address_receive.id', '=', 'orders.address_id')
            ->orderBy($order['field'], $order['dir'])
            ->where('orders.user_id', '=', $userId)
            ->skip($limit['offset'])
            ->take($limit['limit']);

        // Data set length
        $recordsFiltered = $selectLength = DB::table('orders')
            ->leftJoin('users', 'orders.user_id', '=', 'users.id')
            ->leftJoin('address_receive', 'address_receive.id', '=', 'orders.address_id')
            ->select($datatables::pluck($columns, 'db'));

        if ($where) {
            $selectData->whereRaw($where);
            $recordsFiltered->whereRaw($where);
        }

        /*
         * Output
         */
        return array(
            "draw" => intval($request['draw']),
            "recordsTotal" => intval($selectLength->count()),
            "recordsFiltered" => intval($recordsFiltered->count()),
            "data" => $selectData->get()
        );
    }

    public function reportDetailTableOrder($request, $columns)
    {

        $datatables = new DataTables();
        $type = $request['type'];
        $limit = $datatables::limit($request, $columns);
        $order = $datatables::order($request, $columns);
        $where = $datatables::filter($request, $columns);
        $dateSelected = $request['dateSelected'];

        if ($type == 'day')
            $typeWhere = DB::raw('DATE_FORMAT(kacana_orders.created_at, "%Y-%m-%d")');
        elseif ($type == 'month') {
            $dateSelected = substr($dateSelected, 0, 7);
            $typeWhere = DB::raw('DATE_FORMAT(kacana_orders.created_at, "%Y-%m")');
        } elseif ($type == 'year') {
            $dateSelected = substr($dateSelected, 0, 4);
            $typeWhere = DB::raw('DATE_FORMAT(kacana_orders.created_at, "%Y")');
        }
        // Main query to actually get the data
        $selectData = DB::table('orders')
            ->select($datatables::pluck($columns, 'db'))
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->orderBy($order['field'], $order['dir'])
            ->skip($limit['offset'])
            ->take($limit['limit'])
            ->where($typeWhere, '=', $dateSelected);

        // Data set length
        $recordsFiltered = $selectLength = DB::table('orders')
            ->select($datatables::pluck($columns, 'db'))
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->where($typeWhere, '=', $dateSelected);

        if ($where) {
            $selectData->whereRaw($where);
            $recordsFiltered->whereRaw($where);
        }
        /*
         * Output
         */
        return array(
            "draw" => intval($request['draw']),
            "recordsTotal" => intval($selectLength->count()),
            "recordsFiltered" => intval($recordsFiltered->count()),
            "data" => $selectData->get()
        );
    }

    /**
     * @param bool $duration
     * @return mixed
     */
    public function getCountOrder($duration = false)
    {
        $date = Carbon::now()->subDays($duration);
        if ($duration === false)
            return $this->count();
        else
            return $this->where('created_at', '>=', $date)->count();
    }

    /**
     * @param $startTime
     * @param $endTime
     * @param string $type
     * @return mixed
     */
    public function reportOrder($startTime, $endTime, $type = 'date')
    {
        $orderReport = $this->where('created_at', '>=', $startTime)
            ->where('created_at', '<=', $endTime);
        if ($type == 'day')
            $orderReport->select('*', DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as date'), (DB::raw('SUM(total) as item')))
                ->groupBy('date');
        elseif ($type == 'month')
            $orderReport->select('*', DB::raw('DATE_FORMAT(created_at, "%Y-%m") as date'), (DB::raw('SUM(total) as item')))
                ->groupBy('date');
        elseif ($type == 'year')
            $orderReport->select('*', DB::raw('DATE_FORMAT(created_at, "%Y") as date'), (DB::raw('SUM(total) as item')))
                ->groupBy('date');

        return $orderReport->get();
    }

    public function exportOrderByDuration($from = false, $to = false)
    {
        $order = $this;

        if ($from) {
            $order = $order->where('created_at', '>=', $from);
        } else {
            $from = Carbon::now()->subDays(30);
            $order = $order->where('created_at', '>=', $from);
        }

        if($to){
            $order = $order->where('created_at', '<=', $to);
        }

        return $order->get();
    }
}
