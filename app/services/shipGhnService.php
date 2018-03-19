<?php namespace App\services;

use Httpful\Request as Client;
use App\services\orderService;
use App\models\shippingModel;
use Kacana\Client\Slack;
use Kacana\DataTables;
use Kacana\ViewGenerateHelper;
use Cache;
use Kacana\Client\SpeedSms;
use League\Flysystem\Exception;

/**
 * Class shipGhnService
 * @package App\services
 */
class shipGhnService extends baseService {
    /**
     * @var Client
     */
    protected $_client;

    /**
     * @var string
     */
    protected $_key;

    /**
     * @var string
     */
    protected $_secretKey;

    /**
     * @var string
    protected $_clientId;

    /**
     * @var string
     */
    protected $_password;

    /**
     * @var string
     */
    protected $_baseApiUrl;

    /**
     * @var shippingModel
     */
    protected $_shippingModel;

    /**
     * shipGhnService constructor.
     */
    public function __construct(){

        $this->_key = KACANA_SHIP_GHN_API_KEY;
        $this->_secretKey = KACANA_SHIP_GHN_API_SECRET_KEY;
        $this->_clientId = KACANA_SHIP_GHN_API_CLIENT_ID;
        $this->_password = KACANA_SHIP_GHN_API_PASSWORD;
        $this->_baseApiUrl = KACANA_SHIP_GHN_API_URL;

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
    public function makeRequest($function, $params = [], $type = 'post'){

        if(!in_array($type, ['get', 'post', 'put', 'delete', 'head', 'options']))
            return false;

        $url = $this->_baseApiUrl.$function;
        $this->_client = Client::$type($url);


        $header = ['Content-Type' => 'application/json'];

        $baseParams = [
            'ApiKey' => $this->_key,
            'ApiSecretKey' => $this->_secretKey,
            'ClientID' => $this->_clientId,
            'Password' => $this->_password
        ];

        $configParam = array_merge($baseParams, $params);

        return $this->_client
            ->addHeaders($header)
            ->body(json_encode($configParam))
            ->send();
    }

    /**
     * get information sign in
     *
     * @return bool
     */
    public function signin(){
        $results = $this->makeRequest('signin');
        return $results->body;
    }

    /**
     * @return mixed
     */
    public function GetDistrictProvinceData(){
        $results = $this->makeRequest('GetDistrictProvinceData');
        return $results->body->Data;
    }

    /**
     *generate city and district for database
     *
     *
     */
    public function createAddressFromApi(){
        $results = $this->GetDistrictProvinceData();
        $adressService = new addressService();
        $arrayCity = [];
        $arrayCitys = [];
        foreach($results as $result){
            if(!in_array($result->ProvinceCode, $arrayCity))
            {
                $city = $adressService->createCity($result->ProvinceName, KACANA_SHIP_TYPE_SERVICE_GHN, $result->ProvinceCode);
                array_push($arrayCity, $result->ProvinceCode);
                $arrayCitys[$result->ProvinceCode] = $city->id;
            }
            $adressService->createDistrict($result->DistrictName,$arrayCitys[$result->ProvinceCode], $result->DistrictCode, KACANA_SHIP_TYPE_SERVICE_GHN);
        }
    }

    /**
     * @param $toDistrictCode
     * @param $fromDistrictCode
     * @return mixed
     */
    public function getServiceList($toDistrictCode, $fromDistrictCode){
        $params = array(
            'FromDistrictCode' => $fromDistrictCode,
            'ToDistrictCode' => $toDistrictCode
        );

        $results = $this->makeRequest('GetServiceList', $params);

        if(isset($results->body->Services))
            return $results->body->Services;
        return [];
    }

    /**
     * @return mixed
     */
    public function getPickHubs(){
        $keyCachePickHubs = '__Key_Cache_Pick_Hubs_GHN__';

        if(Cache::get($keyCachePickHubs))
            return Cache::get($keyCachePickHubs);
        try{
            $results = $this->makeRequest('GetPickHubs');
            if(isset($results->body->HubInfo))
            {
                Cache::put($keyCachePickHubs, $results->body->HubInfo, 1440);

                return $results->body->HubInfo;
            }
        }catch (Exception $e){
            return [];
        }

        return [];
    }

    public function getPickHubById($id)
    {
        $pickHubs = $this->getPickHubs();
        $pickHubReturn = false;

        if(count($pickHubs)){
            foreach ($pickHubs as $pickHub)
            {
                if($pickHub->PickHubID == $id)
                    $pickHubReturn = $pickHub;
            }
        }

        return $pickHubReturn;
    }

    /**
     * @param $hubInfos
     * @return bool
     */
    public function getPickHubMain($hubInfos){
        foreach($hubInfos as $hub){
            if($hub->IsMain)
                return $hub;
        }

        return false;
    }

    /**
     * @param $toDistrictCode
     * @param $pickDistrictCode
     * @param bool $typeService
     * @param int $weight
     * @param int $length
     * @param int $width
     * @param int $height
     * @return bool
     */
    public function serviceInfos($toDistrictCode, $pickDistrictCode, $typeService = false,
                                 $weight = KACANA_SHIP_DEFAULT_WEIGHT,
                                 $length = KACANA_SHIP_DEFAULT_LENGTH,
                                 $width = KACANA_SHIP_DEFAULT_WIDTH,
                                 $height = KACANA_SHIP_DEFAULT_HEIGHT){

        $params = array(
            'FromDistrictCode' => $pickDistrictCode,
            'ToDistrictCode' => $toDistrictCode,
            'Weight'=> $weight,
            'Length'=> $length,
            'Width'=> $width,
            'Height'=> $height,
        );

        $results = $this->makeRequest('ServiceInfos', $params);
        $results = $results->body->Services;

        foreach($results as &$result)
        {
            $result->ServiceFee = formatMoney($result->ServiceFee);
            $result->ExpectedDeliveryTimeShow = substr($result->ExpectedDeliveryTime, 0, 10);
            if($result->ServiceID == $typeService)
                return $result;
        }


        return $results;

    }

    public function calculateServiceFee($toDistrictCode, $pickDistrictCode, $serviceCodes = false,
                                        $weight = KACANA_SHIP_DEFAULT_WEIGHT,
                                        $length = KACANA_SHIP_DEFAULT_LENGTH,
                                        $width = KACANA_SHIP_DEFAULT_WIDTH,
                                        $height = KACANA_SHIP_DEFAULT_HEIGHT){
        $itemsCheck = array();
        if(is_array($serviceCodes))
        {
            foreach($serviceCodes as $serviceCode)
            {
                $params = array(
                    'FromDistrictCode' => $pickDistrictCode,
                    'ToDistrictCode' => $toDistrictCode,
                    'Weight'=> $weight,
                    'Length'=> $length,
                    'Width'=> $width,
                    'Height'=> $height,
                    'ServiceID' => $serviceCode->ShippingServiceID
                );
                array_push($itemsCheck, $params);
            }
        }
        $results = $this->makeRequest('CalculateServiceFee', ['Items'=>json_decode(json_encode($itemsCheck))]);
        $return = [];
        if(isset($results->body->Items))
            $return = $results->body->Items;

        return $return;

    }

    /**
     * @param $orderDetailIds
     * @param $orderId
     * @param $shippingServiceTypeId
     * @param $pickHubId
     * @param $weight
     * @param $length
     * @param $width
     * @param $height
     * @return mixed
     */
    public function createShippingOrder($orderDetailIds, $orderId, $shippingServiceTypeId, $pickHubId, $weight, $length, $width, $height, $originShipFee, $shipFee, $extraDiscount, $extraDiscountDesc, $OrderClientNote, $OrderContentNote, $paid){

        $orderService = new orderService();
        $speedSms = new SpeedSms();
        $params = array();

        $order = $orderService->getOrderById($orderId);
        $orderDetails = $orderService->getOrderDetailByIds($orderDetailIds);

        $subtotal = 0;
        $discount = 0;
        $price = 0;
        foreach($orderDetails as $orderDetail){
            $subtotal += $orderDetail->subtotal;
            $price += $orderDetail->price*$orderDetail->quantity;
        }
        $discount = $price - $subtotal;
        $CODAmount = $subtotal + $shipFee - $extraDiscount - $paid;

        $params['RecipientName'] = $order->addressReceive->name;
        $params['RecipientPhone'] = $order->addressReceive->phone;
        $params['DeliveryAddress'] = $order->address;
        $params['DeliveryDistrictCode'] = $order->addressReceive->district->code;
        $params['ServiceID'] = $shippingServiceTypeId;
        $params['Weight'] = $weight;
        $params['Length'] = $length;
        $params['Width'] = $width;
        $params['Height'] = $height;
        $params['ClientNote'] = $OrderClientNote. '--' .$OrderContentNote;
        $params['SealCode'] = 'kacana_order_'.$orderId;
        $params['CODAmount'] = $CODAmount;
        $params['PickHubID'] = $pickHubId;
        if($order->addressReceive->ward_id)
            $params['ToWardCode'] = $order->addressReceive->ward->code;

        $results = $this->makeRequest('CreateShippingOrder', $params);
        $results = $results->body;

        if($results->ErrorMessage)
            return false;

        $this->createShippingRow($results, $orderDetailIds, $order, $subtotal,$shipFee, $extraDiscount, $extraDiscountDesc, $paid);

        $contentSMS = str_replace('%order_id%', $order->order_code,KACANA_SPEED_SMS_CONTENT_ORDER_PROCESS);
        $contentSMS = str_replace('%user_name%', $orderService->stripVN($order->addressReceive->name),$contentSMS);
        $speedSms->sendSMS([$order->addressReceive->phone], $contentSMS);

        return $results;
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
    public function createShippingRow($shipping, $orderDetailIds, $order, $subtotal,  $shipFee, $extraDiscount, $extraDiscountDesc, $paid){
        $orderService = new orderService();

        $address = $order->addressReceive->name.' - '.$order->address;
        $this->_shippingModel->createShippingRow($shipping->OrderCode, $shipping->TotalFee, KACANA_SHIP_TYPE_SERVICE_GHN, $address, $subtotal, $order->addressReceive->id, $shipFee, $extraDiscount, $extraDiscountDesc, $paid);

        $orderDetails = $orderService->getOrderDetailByIds($orderDetailIds);

        foreach($orderDetails as $orderDetail){
            $orderService->updateOrderDetail($orderDetail->id, ['ship_service_type'=> KACANA_SHIP_TYPE_SERVICE_GHN, 'shipping_service_code' => $shipping->OrderCode, 'order_service_status' => KACANA_ORDER_SERVICE_STATUS_SHIPPING, 'order_id' => $orderDetail->order_id]);
        }

        return true;
    }

    public function generateShippingTable($request){
        $shippingModel = new shippingModel();
        $datatables = new DataTables();
        $viewHelper = new ViewGenerateHelper();

        $columns = array(
            array( 'db' => 'shipping.id', 'dt' => 0 ),
            array( 'db' => 'address_receive.name', 'dt' => 1 ),
            array( 'db' => 'shipping.total', 'dt' => 2 ),
            array( 'db' => 'shipping.fee', 'dt' => 3 ),
            array( 'db' => 'shipping.status', 'dt' => 4 ),
            array( 'db' => 'shipping.created', 'dt' => 5 ),
            array( 'db' => 'shipping.updated', 'dt' => 6 )
        );

        $return = $shippingModel->generateShippingTable($request, $columns);

        if(count($return['data'])) {
            $optionStatus = [KACANA_ORDER_STATUS_NEW, KACANA_ORDER_STATUS_PROCESSING, KACANA_ORDER_STATUS_CANCEL, KACANA_ORDER_STATUS_COMPLETE];

            foreach ($return['data'] as &$res) {
                $res->status = $viewHelper->getStatusDescriptionShip($res->status, $res->id);
                $res->total = formatMoney($res->total);
            }
        }

        $return['data'] = $datatables::data_output( $columns, $return['data'] );

        return $return;
    }

    public function getShippingById($id){
        return $this->_shippingModel->getById($id);
    }

    public function GetOrderInfoStatus($id){
        $params = array(
            'OrderCode' => $id
        );

        $results = $this->makeRequest('GetOrderInfo', $params);
        $results = $results->body;
        $status = $results->CurrentStatus;

        switch ($status){
            case 'Cancel':
                $status = KACANA_SHIP_STATUS_CANCEL;
                break;
            case 'Storing':
                if(isset($results->FirstDeliveredTime))
                    $status = KACANA_SHIP_STATUS_STORE_TO_REDELIVERING;
                else
                    $status = KACANA_SHIP_STATUS_STORING;
                break;
            case 'Delivering':
                $status = KACANA_SHIP_STATUS_DELIVERING;
                break;
            case 'Return':
                $status = KACANA_SHIP_STATUS_RETURN;
                break;
            case 'WaitingToFinish':
                $status = KACANA_SHIP_STATUS_WAITING_TO_FINISH;
                break;
            case 'Finish':
                if(isset($results->body->EndReturnTime))
                    $status = KACANA_SHIP_STATUS_RETURNED;
                else
                    $status = KACANA_SHIP_STATUS_FINISH;
                break;
            default:
                $status = KACANA_SHIP_STATUS_READY_TO_PICK;
        }

        return $status;
    }

    public function updateShippingStatus($id, $status){
        $this->notificationSlackShipping($id, $status);
        return $this->_shippingModel->updateShippingStatus($id, $status);
    }

    public function getAllShippingProcessing(){
        return $this->_shippingModel->getAllShippingProcessing();
    }

    public function notificationSlackShipping($shippingId, $status)
    {

        $shipping = $this->_shippingModel->getById($shippingId);
        $typeShipping = '';
        if ($shipping->ship_service_type == KACANA_SHIP_TYPE_SERVICE_GHN) {
            $typeShipping = 'Giao Hàng Nhanh';
            $url = 'https://5sao.ghn.vn/Tracking/ViewTracking/';
        } elseif ($shipping->ship_service_type == KACANA_SHIP_TYPE_SERVICE_GHTK) {
            $typeShipping = 'Giao Hàng Tiết kiệm';
            $url = 'https://khachhang.giaohangtietkiem.vn/khach-hang/tracking/order?orderId=';
        }

        if (in_array($status, [KACANA_SHIP_STATUS_RE_DELIVERING, KACANA_SHIP_STATUS_RETURN, KACANA_SHIP_STATUS_FINISH]) && $shipping->status != $status) {
            $slack = new Slack('shipping_status');

            if ($status == KACANA_SHIP_STATUS_RE_DELIVERING) {
                $slackText = 'Warning: Giao hàng LẠI với đơn hàng ' . $shippingId . ' của ' . $typeShipping;
                $color = '#ffc107';
            } elseif ($status == KACANA_SHIP_STATUS_RETURN) {
                $slackText = 'Error: Giao hàng THẤT BẠI với đơn hàng ' . $shippingId . ' của ' . $typeShipping;
                $color = '#dc3545';
            } elseif ($status == KACANA_SHIP_STATUS_FINISH) {
                $slackText = 'Success: Giao hàng THÀNH CÔNG với đơn hàng ' . $shippingId . ' của ' . $typeShipping;
                $color = '#28a745';
            }

            $attachAddress = [
                'fallback' => 'Địa chỉ nhận hàng',
                'text' => 'Địa chỉ nhận hàng',
                'color' => $color,
                'fields' => [
                    [
                        'title' => 'Người Nhận',
                        'value' => $shipping->addressReceive->name . ' ' . $shipping->addressReceive->phone,
                        'short' => true
                    ],
                    [
                        'title' => 'Địa chỉ',
                        'value' => $shipping->address,
                        'short' => true
                    ]
                ],
                "title" => $shippingId,
                "title_link" => $url.$shippingId
            ];

            $attachProducts = [];

            foreach ($shipping->orderDetail as $orderDetail){

                $imageUrl = "http://image.kacana.vn".str_replace('%2F', '/', urlencode($orderDetail->product->getOriginal('image')));
                $attachProduct = [
                    "color" => $color,
                    "title" => $orderDetail->name,
                    "title_link" => "http://kacana.vn/san-pham/san-pham--".$orderDetail->product_id.'--387',
                    "thumb_url" => $imageUrl,
                    'fields' => [
                        [
                            'title' => 'Số lượng',
                            'value' => $orderDetail->quantity,
                            'short' => true
                        ],
                        [
                            'title' => 'Tổng',
                            'value' => formatMoney($orderDetail->price - $orderDetail->discount).'(Giảm: '.formatMoney($orderDetail->discount).')',
                            'short' => true
                        ]
                    ]
                ];
                array_push($attachProducts, $attachProduct);
            }

            $slack->notificationNewOrder($slackText,$attachAddress, $attachProducts);
        }
    }
}



?>