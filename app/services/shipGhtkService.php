<?php namespace App\services;

use App\models\addressDistrictModel;
use Httpful\Request as Client;
use App\models\shippingModel;
use Kacana\Client\SpeedSms;
use Kacana\DataTables;
use Kacana\ViewGenerateHelper;
use Cache;


class shipGhtkService extends baseService {
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
     * shipGhnService constructor.
     */
    public function __construct(){

        $this->_token = KACANA_SHIP_GHTK_API_TOKEN;
        $this->_baseApiUrl = KACANA_SHIP_GHTK_API_URL;
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

        return $this->_client
            ->addHeaders($header)
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
        $pick_district = 'Quận 5';

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
            ["pick_province" => $pick_province,
              "pick_district" => $pick_district,
              "province" => $province,
              "district" => $district,
              "address" => $address,
              "weight" => $weight,
              "value" => $value ];


        $results = $this->makeRequest('services/shipment/fee', $params);
        return $results->body;
    }

    public function createShippingOrder($orderDetailIds, $orderId, $shippingServiceTypeId, $pickHubId, $weight, $length, $width, $height, $originShipFee, $shipFee, $extraDiscount, $extraDiscountDesc, $OrderClientNote, $OrderContentNote, $paid){

        $orderService = new orderService();
        $shipGhnService = new shipGhnService();
        $speedSms = new SpeedSms();
        $districtModel = new addressDistrictModel();

        $params = array();

        $order = $orderService->getOrderById($orderId);
        $orderDetails = $orderService->getOrderDetailByIds($orderDetailIds);

        $subtotal = 0;
        $discount = 0;
        $dataPost = [];
        $dataPost['products'] = [];
        foreach($orderDetails as $orderDetail){
            $subtotal += $orderDetail->subtotal;
            $discount += $orderDetail->discount;

            $productOrder['name'] = $orderDetail->name;
            $productOrder['weight'] = number_format((float)($weight/(count($orderDetails))), 2, '.', '');
            array_push($dataPost['products'], $productOrder);
        }
        $CODAmount = $subtotal + $shipFee - $extraDiscount - $paid;

        $params['id'] = $orderId;
        $params['pick_name'] = 'Kacana';
        $params['pick_money'] = $CODAmount;
        $params['pick_tel'] = '0906054206';

        $pickHub = false;
        if($pickHubId)
            $pickHub = $shipGhnService->getPickHubById($pickHubId);

        if($pickHub)
        {
            $pickDistrictObject = $districtModel->getDistrictByCode($pickHub->DistrictCode, KACANA_SHIP_TYPE_SERVICE_GHN);
            $params['pick_address'] = $pickHub->Address;
            $params['pick_province'] = $pickDistrictObject->city->name;
            $params['pick_district'] = $pickDistrictObject->name;
        }
        else
        {
            $params['pick_address'] = 'số nhà 60/36';
            $params['pick_province'] = 'Hồ Chí Minh';
            $params['pick_district'] = 'Quận 5';
            $params['pick_street'] = 'Trần Hưng Đạo';
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
print_r($results->body);die;
        $shipGhnService->createShippingRow($results->body, $orderDetailIds, $order, $subtotal,$shipFee, $extraDiscount, $extraDiscountDesc, $paid);

        $contentSMS = str_replace('%order_id%', $order->order_code,KACANA_SPEED_SMS_CONTENT_ORDER_PROCESS);
        $contentSMS = str_replace('%user_name%', $orderService->stripVN($order->addressReceive->name),$contentSMS);
        $speedSms->sendSMS([$order->addressReceive->phone], $contentSMS);

        return $results->body;
    }

}



?>