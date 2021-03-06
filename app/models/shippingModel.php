<?php namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Kacana\DataTables;
use DB;

/**
 * Class addressReceiveModel
 * @package App\models
 */
class shippingModel extends Model {

    /**
     * @var string
     */
    protected $table = 'shipping';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function addressReceive()
    {
        return $this->belongsTo('App\models\addressReceiveModel', 'address_receive_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderDetail()
    {
        return $this->hasMany('App\models\orderDetailModel', 'shipping_service_code', 'id');
    }

    /**
     * @param $shippingData
     * @param $address
     * @param $subtotal
     * @param $addressReceiveId
     * @return bool
     */
    public function createShippingRow($orderCode, $totalFee, $shipServiceType, $address, $subtotal, $addressReceiveId,  $shipFee, $extraDiscount, $extraDiscountDesc, $paid, $expecteDeliveryTime = ''){
        $shipping = new shippingModel();

        $shipping->id = $orderCode;
        $shipping->origin_fee  = $totalFee;
        $shipping->ship_service_type  = $shipServiceType;
        $shipping->fee  = $shipFee;
        $shipping->extra_discount  = $extraDiscount;
        $shipping->extra_discount_desc  = $extraDiscountDesc;
        $shipping->total  = $subtotal;
        $shipping->paid  = $paid;
        $shipping->address  = $address;
        $shipping->expected_delivery_time  = $expecteDeliveryTime;
        $shipping->address_receive_id  = $addressReceiveId;
        $shipping->created = date('Y-m-d H:i:s');
        $shipping->updated = date('Y-m-d H:i:s');

        return $shipping->save();
    }

    public function generateShippingTable($request, $columns){

        $datatables = new DataTables();

        $limit = $datatables::limit( $request, $columns );
        $order = $datatables::order( $request, $columns );
        $where = $datatables::filter( $request, $columns );

        // Main query to actually get the data
        $selectData = DB::table('shipping')
            ->select($datatables::pluck($columns, 'db'))
            ->join('address_receive', 'shipping.address_receive_id', '=', 'address_receive.id')
            ->orderBy($order['field'], $order['dir'])
            ->skip($limit['offset'])
            ->take($limit['limit']);

        // Data set length
        $recordsFiltered = $selectLength = DB::table('shipping')
            ->select($datatables::pluck($columns, 'db'))
            ->join('address_receive', 'address_receive.id', '=', 'shipping.address_receive_id');

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
     * @param $id
     * @return \Illuminate\Support\Collection|null|static
     */
    public function getById($id){
        return $this->find($id);
    }

    public function updateShippingStatus($id, $status){
        $this->where('id', $id)->update(['status' => $status]);
        return $this->find($id);
    }

    public function getAllShippingProcessing(){
        return $this->whereNotIn('status', [KACANA_SHIP_STATUS_FINISH, KACANA_SHIP_STATUS_CANCEL])->get();
    }
}