<?php namespace App\models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class orderDetailModel extends Model  {
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'order_detail';
    public $timestamps = false;

    /**
     * Get the order detail associated with order
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function order()
    {
        return $this->belongsTo('App\models\orderModel', 'order_id');
    }

    public function shipping()
    {
        return $this->belongsTo('App\models\shippingModel', 'shipping_service_code');
    }

    public function color()
    {
        return $this->belongsTo('App\models\tagModel', 'color_id');
    }

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
    public function getItemsByOrderId($id){
        return $this->where('order_id', $id)->get();
    }

    /*
     * Delete item
     * @param int $id
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

    public function updateOrderDetail($id, $data){
        $this->where('id', $id)->update($data);
        return orderDetailModel::find($id);
    }

    public function getOrderDetailisOrdered($orderId, $addressId){
        $results = $this->where('orders.address_id', $addressId)
            ->select(['order_detail.*', 'orders.address_id as order_address_id'])
            ->join('orders', 'orders.id', '=', 'order_detail.order_id')
            ->whereNull('shipping_service_code')
            ->whereIn('order_service_status', [KACANA_ORDER_SERVICE_STATUS_ORDERED, KACANA_ORDER_SERVICE_STATUS_EXISTS])->get();

        return($results)?$results->toArray():false;
    }

    /*
     * Get Items By Order Id
     *
     * @param int $id
     * @return array
     */
    public function getItemsByOrderIds($ids){
        return $this->whereIn('id', $ids)->get();
    }
}
