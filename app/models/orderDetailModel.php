<?php namespace App\models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

use Kacana\DataTables;
use Kacana\ViewGenerateHelper;

/**
 * Class orderDetailModel
 * @package App\models
 */
class orderDetailModel extends Model  {
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'order_detail';
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the order detail associated with order
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function order()
    {
        return $this->belongsTo('App\models\orderModel', 'order_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shipping()
    {
        return $this->belongsTo('App\models\shippingModel', 'shipping_service_code');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function color()
    {
        return $this->belongsTo('App\models\tagModel', 'color_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function size()
    {
        return $this->belongsTo('App\models\tagModel', 'size_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo('App\models\productModel', 'product_id');
    }

    public function partnerPaymentDetail()
    {
        return $this->hasOne('App\models\partnerPaymentDetailModel', 'order_detail_id', 'id');
    }

    public function discountProductRef(){
        return $this->belongsTo('App\models\productModel', 'discount_ref');
    }

    /**
     * @param $orderId
     * @param $carts
     * @return bool
     */
    public function createItems($orderId, $carts){
        if(count($carts)>0){
            foreach($carts as $item){
                $orderObj= new OrderDetail();

                $orderObj->order_id = $orderId;
                $orderObj->name = $item->name;
                $orderObj->price = $item->price;
                $orderObj->quantity = $item->qty;
                $orderObj->subtotal = $item->subtotal;
                $orderObj->product_id = $item->id;
                $orderObj->created = date('Y-m-d H:i:s');
                $orderObj->updated = date('Y-m-d H:i:s');
                if(isset($item->options['color'])){
                    $orderObj->color = $item->options['color'][0];
                }

                $orderObj->save();
            }
        }
        return true;
    }

    /**
     * @param $item
     * @return orderDetailModel
     */
    public function createItem($item)
    {
        $object = new orderDetailModel();
        foreach($item as $key=>$value){
            if($value)
                $object->{$key} = $value;
        }
        $object->created = date('Y-m-d H:i:s');
        $object->updated = date('Y-m-d H:i:s');
        $object->save();
        return $object;
    }

    /*
     * Get Items By Order Id
     *
     * @param int $id
     * @return array
     */
    /**
     * @param $id
     * @return mixed
     */
    public function getItemsByOrderId($id){
        return $this->where('order_id', $id)->get();
    }

    /*
     * Delete item
     * @param int $id
     */
    /**
     * @param $id
     * @return bool
     */
    public function deleteItem($id){
        $order_detail = OrderDetail::find($id);
        $order = $order_detail->order;
        $subtotal = $order_detail->subtotal;
        if($order_detail->delete()){
            $order->total = $order->total - $subtotal;
            $order->save();
            return true;
        }
        return false;
    }

    /**
     * @param $id
     * @param $data
     * @return \Illuminate\Support\Collection|null|static
     */
    public function updateOrderDetail($id, $data){
        $this->where('id', $id)->update($data);
        return orderDetailModel::find($id);
    }

    /**
     * @param $orderId
     * @param $addressId
     * @return bool
     */
    public function getOrderDetailisOrdered($orderId, $addressId){
        $results = $this->where('orders.address_id', $addressId)
            ->select(['order_detail.*', 'orders.address_id as order_address_id'])
            ->join('orders', 'orders.id', '=', 'order_detail.order_id')
            ->whereNull('shipping_service_code')->get();

        return($results)?$results->toArray():false;
    }

    /*
     * Get Items By Order Id
     *
     * @param int $id
     * @return array
     */
    /**
     * @param $ids
     * @return mixed
     */
    public function getItemsByOrderIds($ids){
        return $this->whereIn('id', $ids)->get();
    }

    public function getItemsById($id){
        return $this->find($id);
    }

    /**
     * @param $orderId
     * @param $orderDetailId
     */
    public function deleteOrderDetail($orderId, $orderDetailId){
        $select = $this->where('order_id', $orderId)
            ->where('id', $orderDetailId);

        $select->delete();
    }

    /**
     * @param $orderId
     * @return mixed
     */
    public function getOrderDetailNotProcess($orderId){
        return $this->where('order_id', $orderId)
            ->where(function ($query){
                $query->whereNull('order_service_status')
                    ->orWhere('order_service_status', KACANA_ORDER_SERVICE_STATUS_ORDERED);
            })
            ->get();
    }

    /**
     * @param $request
     * @param $columns
     * @return array
     */
    public function generateAllCommissionTable($request, $columns, $userId){

        $datatables = new DataTables();

        $limit = $datatables::limit( $request, $columns );
        $order = $datatables::order( $request, $columns );
        $where = $datatables::filter( $request, $columns );

        // Main query to actually get the data
        $selectData = DB::table('order_detail')
            ->select($datatables::pluck($columns, 'db'))
            ->leftJoin('orders', 'order_detail.order_id', '=', 'orders.id')
            ->leftJoin('shipping', 'shipping.id', '=', 'order_detail.shipping_service_code')
            ->leftJoin('partner_payment_detail', 'order_detail.id', '=', 'partner_payment_detail.order_detail_id')
            ->leftJoin('partner_payments', 'partner_payment_detail.payment_id', '=', 'partner_payments.id')
            ->orderBy($order['field'], $order['dir'])
            ->where('orders.user_id', '=', $userId)
            ->whereIn('orders.status', [KACANA_ORDER_STATUS_PROCESSING, KACANA_ORDER_STATUS_NEW, KACANA_ORDER_STATUS_CANCEL, KACANA_ORDER_STATUS_COMPLETE])
            ->skip($limit['offset'])
            ->take($limit['limit']);

        // Data set length
        $recordsFiltered = $selectLength = DB::table('order_detail')
            ->leftJoin('orders', 'order_detail.order_id', '=', 'orders.id')
            ->leftJoin('shipping', 'shipping.id', '=', 'order_detail.shipping_service_code')
            ->leftJoin('partner_payment_detail', 'order_detail.id', '=', 'partner_payment_detail.order_detail_id')
            ->leftJoin('partner_payments', 'partner_payment_detail.payment_id', '=', 'partner_payments.id')
            ->where('orders.user_id', '=', $userId)
            ->whereIn('orders.status', [KACANA_ORDER_STATUS_PROCESSING, KACANA_ORDER_STATUS_NEW, KACANA_ORDER_STATUS_CANCEL, KACANA_ORDER_STATUS_COMPLETE])
            ->select($datatables::pluck($columns, 'db'));

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
     * @param $request
     * @param $columns
     * @return array
     */
    public function generateTempCommissionTable($request, $columns, $userId){

        $datatables = new DataTables();

        $limit = $datatables::limit( $request, $columns );
        $order = $datatables::order( $request, $columns );
        $where = $datatables::filter( $request, $columns );

        // Main query to actually get the data
        $selectData = DB::table('order_detail')
            ->select($datatables::pluck($columns, 'db'))
            ->leftJoin('orders', 'order_detail.order_id', '=', 'orders.id')
            ->leftJoin('shipping', 'shipping.id', '=', 'order_detail.shipping_service_code')
            ->leftJoin('partner_payment_detail', 'order_detail.id', '=', 'partner_payment_detail.order_detail_id')
            ->leftJoin('partner_payments', 'partner_payment_detail.payment_id', '=', 'partner_payments.id')
            ->orderBy($order['field'], $order['dir'])
            ->where('orders.user_id', '=', $userId)
            ->whereIn('orders.status', [KACANA_ORDER_STATUS_PROCESSING, KACANA_ORDER_STATUS_NEW, KACANA_ORDER_STATUS_COMPLETE])
            ->where(function ($query){
                $query->where('order_detail.order_service_status', '!=',KACANA_ORDER_SERVICE_STATUS_SOLD_OUT)
                    ->orWhereNull('order_detail.order_service_status');
            })
            ->where(function ($query){
                $query->where('shipping.status', '!=',KACANA_SHIP_STATUS_CANCEL)
                    ->orWhereNull('shipping.status');
            })
            ->whereNull('partner_payment_detail.payment_id')
            ->skip($limit['offset'])
            ->take($limit['limit']);

        // Data set length
        $recordsFiltered = $selectLength = DB::table('order_detail')
            ->leftJoin('orders', 'order_detail.order_id', '=', 'orders.id')
            ->leftJoin('shipping', 'shipping.id', '=', 'order_detail.shipping_service_code')
            ->leftJoin('partner_payment_detail', 'order_detail.id', '=', 'partner_payment_detail.order_detail_id')
            ->leftJoin('partner_payments', 'partner_payment_detail.payment_id', '=', 'partner_payments.id')
            ->where('orders.user_id', '=', $userId)
            ->whereIn('orders.status', [KACANA_ORDER_STATUS_PROCESSING, KACANA_ORDER_STATUS_NEW, KACANA_ORDER_STATUS_COMPLETE])
            ->where(function ($query){
                $query->where('order_detail.order_service_status', '!=',KACANA_ORDER_SERVICE_STATUS_SOLD_OUT)
                    ->orWhereNull('order_detail.order_service_status');
            })
            ->where(function ($query){
                $query->where('shipping.status', '!=',KACANA_SHIP_STATUS_CANCEL)
                    ->orWhereNull('shipping.status');
            })
            ->whereNull('partner_payment_detail.payment_id')
            ->where('shipping.status', '!=',KACANA_SHIP_STATUS_CANCEL)
            ->select($datatables::pluck($columns, 'db'));

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
     * @param $request
     * @param $columns
     * @return array
     */
    public function generateValidCommissionTable($request, $columns, $userId){

        $datatables = new DataTables();

        $limit = $datatables::limit( $request, $columns );
        $order = $datatables::order( $request, $columns );
        $where = $datatables::filter( $request, $columns );

        // Main query to actually get the data
        $selectData = DB::table('order_detail')
            ->select($datatables::pluck($columns, 'db'))
            ->leftJoin('orders', 'order_detail.order_id', '=', 'orders.id')
            ->leftJoin('shipping', 'shipping.id', '=', 'order_detail.shipping_service_code')
            ->leftJoin('partner_payment_detail', 'order_detail.id', '=', 'partner_payment_detail.order_detail_id')
            ->leftJoin('partner_payments', 'partner_payment_detail.payment_id', '=', 'partner_payments.id')
            ->orderBy($order['field'], $order['dir'])
            ->where('orders.user_id', '=', $userId)
            ->where('shipping.status', KACANA_SHIP_STATUS_FINISH)
            ->whereNull('partner_payment_detail.payment_id')
            ->skip($limit['offset'])
            ->take($limit['limit']);

        // Data set length
        $recordsFiltered = $selectLength = DB::table('order_detail')
            ->leftJoin('orders', 'order_detail.order_id', '=', 'orders.id')
            ->leftJoin('shipping', 'shipping.id', '=', 'order_detail.shipping_service_code')
            ->leftJoin('partner_payment_detail', 'order_detail.id', '=', 'partner_payment_detail.order_detail_id')
            ->leftJoin('partner_payments', 'partner_payment_detail.payment_id', '=', 'partner_payments.id')
            ->where('orders.user_id', '=', $userId)
            ->where('shipping.status', KACANA_SHIP_STATUS_FINISH)
            ->whereNull('partner_payment_detail.payment_id')
            ->select($datatables::pluck($columns, 'db'));

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
     * @param $request
     * @param $columns
     * @return array
     */
    public function generatePaymentCommissionTable($request, $columns, $userId){

        $datatables = new DataTables();

        $limit = $datatables::limit( $request, $columns );
        $order = $datatables::order( $request, $columns );
        $where = $datatables::filter( $request, $columns );

        // Main query to actually get the data
        $selectData = DB::table('order_detail')
            ->select($datatables::pluck($columns, 'db'))
            ->leftJoin('orders', 'order_detail.order_id', '=', 'orders.id')
            ->leftJoin('shipping', 'shipping.id', '=', 'order_detail.shipping_service_code')
            ->leftJoin('partner_payment_detail', 'order_detail.id', '=', 'partner_payment_detail.order_detail_id')
            ->leftJoin('partner_payments', 'partner_payment_detail.payment_id', '=', 'partner_payments.id')
            ->orderBy($order['field'], $order['dir'])
            ->where('orders.user_id', '=', $userId)
            ->where('shipping.status', KACANA_SHIP_STATUS_FINISH)
            ->where('partner_payment_detail.payment_id', '>', 0)
            ->skip($limit['offset'])
            ->take($limit['limit']);

        // Data set length
        $recordsFiltered = $selectLength = DB::table('order_detail')
            ->leftJoin('orders', 'order_detail.order_id', '=', 'orders.id')
            ->leftJoin('shipping', 'shipping.id', '=', 'order_detail.shipping_service_code')
            ->leftJoin('partner_payment_detail', 'order_detail.id', '=', 'partner_payment_detail.order_detail_id')
            ->leftJoin('partner_payments', 'partner_payment_detail.payment_id', '=', 'partner_payments.id')
            ->where('orders.user_id', '=', $userId)
            ->where('shipping.status', KACANA_SHIP_STATUS_FINISH)
            ->where('partner_payment_detail.payment_id', '>', 0)
            ->select($datatables::pluck($columns, 'db'));

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
     * @param $userId
     * @return mixed
     */
    public function allCommission($userId){

        $selectData =  $this->leftJoin('orders', 'order_detail.order_id', '=', 'orders.id')
            ->leftJoin('shipping', 'shipping.id', '=', 'order_detail.shipping_service_code')
            ->leftJoin('partner_payment_detail', 'order_detail.id', '=', 'partner_payment_detail.order_detail_id')
            ->where('orders.user_id', '=', $userId)
            ->whereIn('orders.status', [KACANA_ORDER_STATUS_PROCESSING, KACANA_ORDER_STATUS_NEW, KACANA_ORDER_STATUS_CANCEL, KACANA_ORDER_STATUS_COMPLETE]);

        return $selectData->get();
    }

    /**
     * @param $userId
     * @return mixed
     */
    public function tempCommission($userId){

        $selectData = $this->leftJoin('orders', 'order_detail.order_id', '=', 'orders.id')
            ->leftJoin('shipping', 'shipping.id', '=', 'order_detail.shipping_service_code')
            ->leftJoin('partner_payment_detail', 'order_detail.id', '=', 'partner_payment_detail.order_detail_id')
            ->where('orders.user_id', '=', $userId)
            ->whereIn('orders.status', [KACANA_ORDER_STATUS_PROCESSING, KACANA_ORDER_STATUS_NEW, KACANA_ORDER_STATUS_COMPLETE])
            ->where(function ($query){
                $query->where('order_detail.order_service_status', '!=',KACANA_ORDER_SERVICE_STATUS_SOLD_OUT)
                    ->orWhereNull('order_detail.order_service_status');
            })
            ->where(function ($query){
                $query->where('shipping.status', '!=',KACANA_SHIP_STATUS_CANCEL)
                    ->orWhereNull('shipping.status');
            })
            ->whereNull('partner_payment_detail.payment_id');

        return $selectData->get();
    }

    /**
     * @param $userId
     * @return mixed
     */
    public function validCommission($userId){
        $selectData = $this->leftJoin('orders', 'order_detail.order_id', '=', 'orders.id')
            ->leftJoin('shipping', 'shipping.id', '=', 'order_detail.shipping_service_code')
            ->leftJoin('partner_payment_detail', 'order_detail.id', '=', 'partner_payment_detail.order_detail_id')
            ->where('orders.user_id', '=', $userId)
            ->where('shipping.status', KACANA_SHIP_STATUS_FINISH)
            ->select(['order_detail.*'])
            ->whereNull('partner_payment_detail.payment_id');

        return $selectData->get();
    }

    /**
     * @param $userId
     * @return mixed
     */
    public function paymentCommission($userId){
        $selectData = $this->leftJoin('orders', 'order_detail.order_id', '=', 'orders.id')
            ->leftJoin('shipping', 'shipping.id', '=', 'order_detail.shipping_service_code')
            ->leftJoin('partner_payment_detail', 'order_detail.id', '=', 'partner_payment_detail.order_detail_id')
            ->where('orders.user_id', '=', $userId)
            ->where('shipping.status', KACANA_SHIP_STATUS_FINISH)
            ->where('partner_payment_detail.payment_id', '>', 0);

        return $selectData->get();
    }

    /**
 * @param $request
 * @param $columns
 * @param $userId
 * @param $addressReceiveId
 * @return array
 */
    public function generateAllCommissionByUserTable($request, $columns, $userId, $addressReceiveId){

        $datatables = new DataTables();

        $limit = $datatables::limit( $request, $columns );
        $order = $datatables::order( $request, $columns );
        $where = $datatables::filter( $request, $columns );

        // Main query to actually get the data
        $selectData = DB::table('order_detail')
            ->select($datatables::pluck($columns, 'db'))
            ->leftJoin('orders', 'order_detail.order_id', '=', 'orders.id')
            ->leftJoin('shipping', 'shipping.id', '=', 'order_detail.shipping_service_code')
            ->leftJoin('partner_payment_detail', 'order_detail.id', '=', 'partner_payment_detail.order_detail_id')
            ->leftJoin('partner_payments', 'partner_payment_detail.payment_id', '=', 'partner_payments.id')
            ->leftJoin('address_receive', 'address_receive.id', '=', 'orders.address_id')
            ->orderBy($order['field'], $order['dir'])
            ->where('address_receive.user_id', '=', $userId)
            ->where('address_receive.id', '=', $addressReceiveId)
            ->whereIn('orders.status', [KACANA_ORDER_STATUS_PROCESSING, KACANA_ORDER_STATUS_NEW, KACANA_ORDER_STATUS_CANCEL, KACANA_ORDER_STATUS_COMPLETE])
            ->skip($limit['offset'])
            ->take($limit['limit']);

        // Data set length
        $recordsFiltered = $selectLength = DB::table('order_detail')
            ->leftJoin('orders', 'order_detail.order_id', '=', 'orders.id')
            ->leftJoin('shipping', 'shipping.id', '=', 'order_detail.shipping_service_code')
            ->leftJoin('partner_payment_detail', 'order_detail.id', '=', 'partner_payment_detail.order_detail_id')
            ->leftJoin('partner_payments', 'partner_payment_detail.payment_id', '=', 'partner_payments.id')
            ->leftJoin('address_receive', 'address_receive.id', '=', 'orders.address_id')
            ->where('address_receive.user_id', '=', $userId)
            ->where('address_receive.id', '=', $addressReceiveId)
            ->whereIn('orders.status', [KACANA_ORDER_STATUS_PROCESSING, KACANA_ORDER_STATUS_NEW, KACANA_ORDER_STATUS_CANCEL, KACANA_ORDER_STATUS_COMPLETE])
            ->select($datatables::pluck($columns, 'db'));

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
     * @param $request
     * @param $columns
     * @param $userId
     * @param $addressReceiveId
     * @return array
     */
    public function generateAllOrderDetailByUserTable($request, $columns, $userId){

        $datatables = new DataTables();

        $limit = $datatables::limit( $request, $columns );
        $order = $datatables::order( $request, $columns );
        $where = $datatables::filter( $request, $columns );

        // Main query to actually get the data
        $selectData = DB::table('order_detail')
            ->select($datatables::pluck($columns, 'db'))
            ->leftJoin('orders', 'order_detail.order_id', '=', 'orders.id')
            ->leftJoin('shipping', 'shipping.id', '=', 'order_detail.shipping_service_code')
            ->leftJoin('partner_payment_detail', 'order_detail.id', '=', 'partner_payment_detail.order_detail_id')
            ->leftJoin('partner_payments', 'partner_payment_detail.payment_id', '=', 'partner_payments.id')
            ->leftJoin('address_receive', 'address_receive.id', '=', 'orders.address_id')
            ->orderBy($order['field'], $order['dir'])
            ->where('address_receive.user_id', '=', $userId)
            ->whereIn('orders.status', [KACANA_ORDER_STATUS_PROCESSING, KACANA_ORDER_STATUS_NEW, KACANA_ORDER_STATUS_CANCEL, KACANA_ORDER_STATUS_COMPLETE])
            ->skip($limit['offset'])
            ->take($limit['limit']);

        // Data set length
        $recordsFiltered = $selectLength = DB::table('order_detail')
            ->leftJoin('orders', 'order_detail.order_id', '=', 'orders.id')
            ->leftJoin('shipping', 'shipping.id', '=', 'order_detail.shipping_service_code')
            ->leftJoin('partner_payment_detail', 'order_detail.id', '=', 'partner_payment_detail.order_detail_id')
            ->leftJoin('partner_payments', 'partner_payment_detail.payment_id', '=', 'partner_payments.id')
            ->leftJoin('address_receive', 'address_receive.id', '=', 'orders.address_id')
            ->where('address_receive.user_id', '=', $userId)
            ->whereIn('orders.status', [KACANA_ORDER_STATUS_PROCESSING, KACANA_ORDER_STATUS_NEW, KACANA_ORDER_STATUS_CANCEL, KACANA_ORDER_STATUS_COMPLETE])
            ->select($datatables::pluck($columns, 'db'));

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
