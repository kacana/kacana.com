<?php namespace App\services;

use App\models\addressDistrictModel;
use Httpful\Request as Client;
use App\models\shippingModel;
use Kacana\Client\SpeedSms;
use Kacana\DataTables;
use Kacana\ViewGenerateHelper;
use Cache;


class shipSuperShipService extends baseService {
    /**
     * @var Client
     */
    protected $_client;

    /**
     * @var string
     */
    protected $_baseApiUrl;

    /**
     * @var string
     */
    protected $_token;

    /**
     * shipSuperShipService constructor.
     */
    public function __construct(){

        $this->_token = KACANA_SHIP_SUPERSHIP_API_TOKEN;
        $this->_baseApiUrl = KACANA_SHIP_SUPERSHIP_API_URL;
        $this->_shippingModel = new shippingModel();
    }

    /**
     * function config to make request
     *
     * @param $params
     * @param $function
     * @param $type (only allow get post put delete head and options)
     * @return bool
     */
    public function makeRequest($function, $params = [], $type = 'get'){

        if(!in_array($type, ['get', 'post', 'put', 'delete', 'head', 'options']))
            return false;

        $url = $this->_baseApiUrl.$function;
        $body = [];

        if($type == 'get')
        {
            $paramStr = '';
            foreach ($params as $key => &$param)
            {
                $param = str_replace('25', '', urlencode($param));
                if($paramStr)
                    $paramStr .='&';
                else
                    $paramStr .= '/?';

                $paramStr .=$key.'='.$param;

            }

            $url .= $paramStr;
            $this->_client = Client::$type($url);
            $header = ['Token' => $this->_token];
        }
        else{
            $this->_client = Client::$type($url);
            $header = ['Content-Type' => 'aplication/json', 'Token' => $this->_token];

        }

        if($type == 'get')
            return $this->_client
                ->addHeaders($header)
                ->send();
        elseif ($type == 'post')
            return $this->_client
                ->addHeaders($header)
                ->sendsJson()
                ->body(json_encode($params))
                ->send();
    }

    public function signin(){
        $results = $this->makeRequest('request-sample');
        return $results->body;
    }

    public function calculateFee($pickDistrictCode, $userAddress, $value = 300000, $weight = 500){

        $districtModel = new addressDistrictModel();

        $pick_province = 'Hồ Chí Minh';
        $pick_district = 'Quận Bình Tân';

        if (isset($pickDistrictCode) && $pickDistrictCode)
        {
            $pickDistrictObject = $districtModel->getDistrictByCode($pickDistrictCode, KACANA_SHIP_TYPE_SERVICE_GHN);
            $pick_province = $pickDistrictObject->city->name;
            $pick_district = $pickDistrictObject->name;
        }

        $address = $userAddress->street;
        if($userAddress->ward_id && isset($userAddress->ward))
            $address .= $userAddress->ward->name;

        $province = $userAddress->city->name;
        $district = $userAddress->district->name;


        $params =
            ["sender_province" => $pick_province,
              "sender_district" => $pick_district,
              "receiver_province" => $province,
              "receiver_district" => $district,
              "address" => $address,
              "weight" => $weight,
              "value" => $value ];


        $results = $this->makeRequest('v1/partner/orders/fee', $params);
        return $results->body;
    }

    public function createShippingOrder($orderDetailIds, $orderId, $pickHubId, $weight, $originShipFee, $shipFee, $extraDiscount, $extraDiscountDesc, $paid){

        $orderService = new orderService();
        $shipGhnService = new shipGhnService();
        $speedSms = new SpeedSms();
        $districtModel = new addressDistrictModel();
        $weight = $weight/1000;

        $params = array();

        $order = $orderService->getOrderById($orderId);
        $orderDetails = $orderService->getOrderDetailByIds($orderDetailIds);

        $subtotal = 0;
        $discount = 0;
        $dataPost = [];
        $dataPost['products'] = [];
        foreach($orderDetails as $orderDetail){
            $subtotal += $orderDetail->subtotal;
            $discount += ($orderDetail->price*$orderDetail->quantity) - $orderDetail->subtotal;

            $productOrder['name'] = $orderDetail->name;
            $productOrder['quantity'] = $orderDetail->quantity;
            $productOrder['price'] = $orderDetail->subtotal;
            $productOrder['weight'] = number_format((float)($weight/(count($orderDetails))), 2, '.', '');
            array_push($dataPost['products'], $productOrder);

            if($orderDetail->discount_type == KACANA_CAMPAIGN_DEAL_TYPE_FREE_PRODUCT){
                $freeProductOrder['name'] = $orderDetail->discountProductRef->name;
                $freeProductOrder['quantity'] = $orderDetail->quantity;
                $freeProductOrder['price'] = 0;
                $freeProductOrder['weight'] = number_format((float)($weight/(count($orderDetails))), 2, '.', '');
                array_push($dataPost['products'], $freeProductOrder);
            }


        }

        $CODAmount = $subtotal + $shipFee - $extraDiscount - $paid;

        $params['id'] = $orderId.'_'.time();
        $params['pickup_commune'] = 'Kacana';
        $params['amount'] = $CODAmount;
        $params['pickup_phone'] = '0906054206';

        $pickHub = false;
        if($pickHubId)
            $pickHub = $shipGhnService->getPickHubById($pickHubId);

        if($pickHub)
        {
            $pickDistrictObject = $districtModel->getDistrictByCode($pickHub->DistrictCode, KACANA_SHIP_TYPE_SERVICE_GHN);
            $params['pickup_address'] = $pickHub->Address;
            $params['pickup_province'] = $pickDistrictObject->city->name;
            $params['pickup_district'] = $pickDistrictObject->name;
        }
        else
        {
            $params['pickup_address'] ='số nhà 129 ( đối diện ), Đường số 1, '.KACANA_HEAD_ADDRESS_WARD;
            $params['pickup_province'] = KACANA_HEAD_ADDRESS_CITY;
            $params['pickup_district'] = KACANA_HEAD_ADDRESS_DISTRICT;
        }

        $params['name'] = $order->addressReceive->name;
        $params['address'] = $order->address;
        $params['province'] = $order->addressReceive->city->name;
        $params['district'] = $order->addressReceive->district->name;

        if($order->addressReceive->ward_id)
            $params['ward'] = $order->addressReceive->ward->name;

        $params['tel'] = $order->addressReceive->phone;
        $params['is_freeship'] = 1;

        if($order->addressReceive->email)
            $params['email'] = $order->addressReceive->email;
        else
            $params['email'] = 'admin@kacana.com';
        $dataPost['order'] = $params;

        $results = $this->makeRequest('services/shipment/order', $dataPost, 'post');

        $this->createShippingRow($results->body, $originShipFee, $orderDetailIds, $order, $subtotal,$shipFee, $extraDiscount, $extraDiscountDesc, $paid, $results->body->order->estimated_deliver_time);

        $contentSMS = str_replace('%order_id%', $order->order_code,KACANA_SPEED_SMS_CONTENT_ORDER_PROCESS);
        $contentSMS = str_replace('%estimated_deliver_time%', $orderService->stripVN($results->body->order->estimated_deliver_time),$contentSMS);
        $contentSMS = str_replace('%user_name%', $orderService->stripVN($order->addressReceive->name),$contentSMS);
        $speedSms->sendSMS([$order->addressReceive->phone], $contentSMS);

        return $results->body;
    }

    /**
     * @param $shipping
     * @param $orderDetailIds
     * @param $order
     * @param $subtotal
     * @param $shipFee
     * @param $extraDiscount
     * @param $extraDiscountDesc
     * @return bool
     */
    public function createShippingRow($shipping, $originShipFee, $orderDetailIds, $order, $subtotal,  $shipFee, $extraDiscount, $extraDiscountDesc, $paid, $expecteDeliveryTime){
        $orderService = new orderService();
        $shippingModel = new shippingModel();


        $address = $order->addressReceive->name.' - '.$order->address;
        $shippingModel->createShippingRow($shipping->order->label, $originShipFee, KACANA_SHIP_TYPE_SERVICE_GHTK, $address, $subtotal, $order->addressReceive->id, $shipFee, $extraDiscount, $extraDiscountDesc, $paid, $expecteDeliveryTime);

        $orderDetails = $orderService->getOrderDetailByIds($orderDetailIds);
        foreach($orderDetails as $orderDetail){
            $orderService->updateOrderDetail($orderDetail->id, ['ship_service_type'=> KACANA_SHIP_TYPE_SERVICE_GHTK, 'shipping_service_code' => $shipping->order->label, 'order_service_status' => KACANA_ORDER_SERVICE_STATUS_SHIPPING, 'order_id' => $orderDetail->order_id]);
        }

        return true;
    }

    public function GetOrderInfoStatus($id){

        $results = $this->makeRequest('/services/shipment/'.$id);

        if(isset($results->body->order))
        {
            $order = $results->body->order;
            $status = $order->status;
        } else {
            $status = -1;
        }

        switch ($status){
            case -1:
                $status = KACANA_SHIP_STATUS_CANCEL;
                break;
            case 3:
            case 123:
                $status = KACANA_SHIP_STATUS_STORING;
                break;
            case 4:
                $status = KACANA_SHIP_STATUS_DELIVERING;
                break;
            case 410:
            case 49:
            case 10:
                $status = KACANA_SHIP_STATUS_RE_DELIVERING;
                break;
            case 9:
            case 20:
                $status = KACANA_SHIP_STATUS_RETURN;
                break;
            case 5:
            case 45:
                $status = KACANA_SHIP_STATUS_WAITING_TO_FINISH;
                break;
            case 21:
            case 11:
                $status = KACANA_SHIP_STATUS_RETURNED;
                break;
            case 6:
                $status = KACANA_SHIP_STATUS_FINISH;
                break;
            default:
                $status = false;
        }

        return $status;
    }

}



?>