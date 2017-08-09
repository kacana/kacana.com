<?php namespace App\services;

use App\models\orderModel;
use App\models\orderDetailModel;
use App\models\orderTypeModel;
use App\services\addressService;
use Kacana\Client\Slack;
use \Kacana\Util;
use Kacana\DataTables;
use Kacana\ViewGenerateHelper;
use Carbon\Carbon;
use Kacana\Client\SpeedSms;
/**
 * Class shipGhnService
 * @package App\services
 */
class orderService extends baseService {

    /**
     * @var orderModel
     */
    private $_orderModel;

    /**
     * @var orderDetailModel
     */
    private $_orderDetailModel;

    /**
     * @var \App\services\addressService
     */
    private $_addressService;

    /**
     * @var orderTypeModel
     */
    private $_orderTypeModel;

    /**
     * orderService constructor.
     */
    public function __construct()
    {
        $this->_orderDetailModel = new orderDetailModel();
        $this->_orderModel = new orderModel();
        $this->_addressService = new addressService();
        $this->_orderTypeModel = new orderTypeModel();
    }


    /**
     *
     * create new order
     *
     * @param $userId
     * @param $addressId
     * @param $total
     * @param $discount
     * @param $originTotal
     * @param $quantity
     * @param $type
     * @param int $status
     * @return orderModel
     */
    public function createOrder($userId, $addressId, $total = 0, $quantity = 0, $originTotal = 0, $discount = 0, $status = KACANA_ORDER_STATUS_NEW, $type = KACANA_ORDER_TYPE_ONLINE){
        $address = $this->_addressService->getAddressReceiveById($addressId);

        $addressStr = $address->street;

        $orderData = new \stdClass();
        $orderData->user_id = $userId;
        $orderData->address_id = $addressId;
        $orderData->total = $total;
        $orderData->quantity = $quantity;
        $orderData->discount = $discount;
        $orderData->origin_total = $originTotal;
        $orderData->status = $status;
        $orderData->order_type = $type;

        if($total < 500000 && $total != 0)
        {
            if($address->city_id == 29)
            {
                $orderData->shipping_fee = 15000;
                $orderData->total = $total + 15000;
            }
            elseif($address->city_id !== NULL){
                $orderData->shipping_fee = 30000;
                $orderData->total = $total + 30000;
            }
        }

        if($addressStr)
            $orderData->address = $addressStr.', '.$address->district->name.', '.$address->city->name;
        else
            $orderData->address = '';

        $order = $this->_orderModel->createItem($orderData);
        $this->_orderModel->updateItem($order->id, ['order_code' => crc32($order->id)]);
        $order->order_code = crc32($order->id);
        return $order;
    }

    /**
     *  create order detail by order_id
     *
     * @param $orderId
     * @param $item
     * @return orderModel
     */
    public function createOrderDetail($orderId, $item){
        $orderDetailData = new \stdClass();

        $name = $item->name;
        if(isset($item->options->colorId))
        {
            $orderDetailData->color_id = $item->options->colorId;
        }

        if(isset($item->options->sizeId))
        {
            $orderDetailData->size_Id = $item->options->sizeId;
        }

        $orderDetailData->order_id =  $orderId;
        $orderDetailData->name = $name;
        $orderDetailData->price = $item->options->origin_price;
        $orderDetailData->discount = $item->options->discount;
        $orderDetailData->quantity = $item->quantity;
        $orderDetailData->product_id = $item->options->productId;
        $orderDetailData->product_url = $item->options->url;
        $orderDetailData->image = $item->options->image;
        $orderDetailData->subtotal = $item->subTotal;

        return $this->_orderDetailModel->createItem($orderDetailData);
    }

    /**
     * @param $item
     * @return orderDetailModel
     */
    public function createOrderDetailAdmin($item){
        return $this->_orderDetailModel->createItem($item);
    }

    /**
     * @param $id
     * @return \Illuminate\Support\Collection|null|static
     */
    public function getOrderById($id){
        $orderModel = new orderModel();
        $order = $orderModel->getById($id);
        return $order;
    }

    /**
     * @param $code
     * @return mixed
     */
    public function getOrderByOrderCode($code){
        $orderModel = new orderModel();
        $order = $orderModel->getOrderByOrderCode($code);
        return $order;
    }


    /**
     * @return int
     */
    public function getTotalOrderCurrentUser(){
        $orderModel = new orderModel();
        $user = Util::getCurrentUser();

        return count($orderModel->getListOrder($user->id));

    }

    /**
     * @param $status
     */
    public function getTotalOrderCurrentByStatus($status){
        $orders = $this->getTotalOrderCurrentUser();

        foreach($orders as $order){

        }

    }

    /**
     * @param $request
     * @return array
     */
    public function generateOrderTable($request){
        $orderModel = new orderModel();
        $datatables = new DataTables();
        $viewHelper = new ViewGenerateHelper();

        $columns = array(
            array( 'db' => 'orders.id', 'dt' => 0 ),
            array( 'db' => 'orders.order_code', 'dt' => 1 ),
            array( 'db' => 'users.name', 'dt' => 2 ),
            array( 'db' => 'address_receive.name AS delivery_name', 'dt' => 3 ),
            array( 'db' => 'address_receive.phone AS delivery_phone', 'dt' => 4 ),
            array( 'db' => 'orders.total', 'dt' => 5 ),
            array( 'db' => 'orders.quantity', 'dt' => 6 ),
            array( 'db' => 'orders.status', 'dt' => 7 ),
            array( 'db' => 'orders.order_type', 'dt' => 8 ),
            array( 'db' => 'orders.created', 'dt' => 9 ),
            array( 'db' => 'orders.updated', 'dt' => 10 )
        );

        $return = $orderModel->generateOrderTable($request, $columns);

        if(count($return['data'])) {
            $typeOrderOption = [KACANA_ORDER_TYPE_ONLINE, KACANA_ORDER_TYPE_STORE_THD];

            foreach ($return['data'] as &$order) {

                if($order->status == KACANA_ORDER_STATUS_NEW )
                    $order->status = '<span class="label label-info">mới tạo</span>';
                elseif($order->status == KACANA_ORDER_STATUS_QUICK_ORDER )
                    $order->status = '<span class="label label-info">>> đặt nhanh</span>';
                elseif($order->status == KACANA_ORDER_STATUS_CANCEL)
                    $order->status = '<span class="label label-danger">KACANA huỷ</span>';
                elseif($order->status == KACANA_ORDER_STATUS_PROCESSING)
                    $order->status = '<span class="label label-waring">đang xử lý</span>';
                elseif($order->status == KACANA_ORDER_STATUS_COMPLETE)
                    $order->status = '<span class="label label-success">hoàn thành</span>';

                $order->order_type = $viewHelper->dropdownView('orders', $order->id, $order->order_type, 'order_type', $typeOrderOption);

                $order->total = formatMoney($order->total);
            }
        }



        $return['data'] = $datatables::data_output( $columns, $return['data'] );

        return $return;
    }

    /**
     * @param $request
     * @param $userId
     * @return array
     */
    public function generateOrderTableByUserId($request, $userId){
        $orderModel = new orderModel();
        $datatables = new DataTables();
        $viewHelper = new ViewGenerateHelper();

        $columns = array(
            array( 'db' => 'orders.order_code', 'dt' => 0 ),
            array( 'db' => 'address_receive.name AS delivery_name', 'dt' => 1 ),
            array( 'db' => 'address_receive.phone AS delivery_phone', 'dt' => 2 ),
            array( 'db' => 'orders.total', 'dt' => 3 ),
            array( 'db' => 'orders.quantity', 'dt' => 4 ),
            array( 'db' => 'orders.status', 'dt' => 5 ),
            array( 'db' => 'orders.created', 'dt' => 6 ),
            array( 'db' => 'orders.updated', 'dt' => 7 )
        );

        $return = $orderModel->generateOrderTableByUserId($request, $columns, $userId);

        if(count($return['data'])) {
            $optionStatus = [KACANA_ORDER_STATUS_NEW, KACANA_ORDER_STATUS_PROCESSING, KACANA_ORDER_STATUS_CANCEL, KACANA_ORDER_STATUS_COMPLETE];

            foreach ($return['data'] as &$order) {

                if($order->status == KACANA_ORDER_PARTNER_STATUS_NEW)
                    $order->status = '<span class="label label-info">mới tạo</span>';
                elseif($order->status == KACANA_ORDER_STATUS_NEW )
                    $order->status = '<span class="label label-info">đã gửi</span>';
                elseif($order->status == KACANA_ORDER_PARTNER_STATUS_CANCEL)
                    $order->status = '<span class="label label-danger">đã huỷ</span>';
                elseif($order->status == KACANA_ORDER_STATUS_CANCEL)
                    $order->status = '<span class="label label-danger">KACANA huỷ</span>';
                elseif($order->status == KACANA_ORDER_STATUS_PROCESSING)
                    $order->status = '<span class="label label-waring">đang xử lý</span>';
                elseif($order->status == KACANA_ORDER_STATUS_COMPLETE)
                    $order->status = '<span class="label label-success">hoàn thành</span>';

                $order->total = formatMoney($order->total);
            }
        }



        $return['data'] = $datatables::data_output( $columns, $return['data'] );

        return $return;
    }

    /**
     * @param $request
     * @return array
     */
    public function reportDetailTableOrder($request){
        $orderModel = new orderModel();
        $datatables = new DataTables();
        $viewHelper = new ViewGenerateHelper();

        $columns = array(
            array( 'db' => 'orders.id', 'dt' => 0 ),
            array( 'db' => 'users.name', 'dt' => 1 ),
            array( 'db' => 'users.phone', 'dt' => 2 ),
            array( 'db' => 'orders.total', 'dt' => 3 ),
            array( 'db' => 'orders.quantity', 'dt' => 4 ),
            array( 'db' => 'orders.status', 'dt' => 5 ),
            array( 'db' => 'orders.created', 'dt' => 6 ),
            array( 'db' => 'orders.updated', 'dt' => 7 )
        );

        $return = $orderModel->reportDetailTableOrder($request, $columns);

        if(count($return['data'])) {
            $optionStatus = [KACANA_ORDER_STATUS_NEW, KACANA_ORDER_STATUS_PROCESSING, KACANA_ORDER_STATUS_CANCEL, KACANA_ORDER_STATUS_COMPLETE];

            foreach ($return['data'] as &$res) {
                $res->status = $viewHelper->dropdownView('orders', $res->id, $res->status, 'status', $optionStatus);
                $res->total = formatMoney($res->total);
            }
        }



        $return['data'] = $datatables::data_output( $columns, $return['data'] );

        return $return;
    }

    /**
     * @param $id
     * @param $data
     * @return \Illuminate\Support\Collection|null|static
     */
    public function updateOrderDetail($id, $data){
        $orderDetailModel = new orderDetailModel();

        if(isset($options['_token'])){
            unset($options['_token']);
        }
        if(isset($options['_method'])){
            unset($options['_method']);
        }

        if(isset($data['order_service_status']) && $data['order_service_status'] == KACANA_ORDER_SERVICE_STATUS_SOLD_OUT && isset($data['order_service_id']))
            unset($data['order_service_id']);

        if(isset($data['order_service_status']) && isset($data['order_id']))
        {
            $orderNotProcessing = $orderDetailModel->getOrderDetailNotProcess($data['order_id']);

            if(count($orderNotProcessing) == 1 && ($data['order_service_status'] == KACANA_ORDER_SERVICE_STATUS_SHIPPING || $data['order_service_status'] == KACANA_ORDER_SERVICE_STATUS_SOLD_OUT))
                $this->_orderModel->updateItem($data['order_id'], ['status' => KACANA_ORDER_STATUS_COMPLETE]);
            else
                $this->_orderModel->updateItem($data['order_id'], ['status' => KACANA_ORDER_STATUS_PROCESSING]);
        }


        unset($data['order_id']);

        return $orderDetailModel->updateOrderDetail($id, $data);
    }

    /**
     * @param $id
     * @param $data
     */
    public function updateOrder($id, $data)
    {
        return $this->_orderModel->updateItem($id, $data);
    }

    /**
     * @param $orderId
     * @param $userId
     * @return bool
     */
    public function getOrderDetailisOrdered($orderId, $addressId)
    {
        $orderDetailModel = new orderDetailModel();

        return $orderDetailModel->getOrderDetailisOrdered($orderId, $addressId);
    }

    /**
     * @param $ids
     * @return mixed
     */
    public function getOrderDetailByIds($ids){
        $orderDetailModel = new orderDetailModel();
        return $orderDetailModel->getItemsByOrderIds($ids);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getOrderDetailById($id){
        $orderDetailModel = new orderDetailModel();
        return $orderDetailModel->getItemsById($id);
    }

    /**
     * @param $email
     * @param $orderCode
     * @return mixed
     */
    public function checkTrackingOrderCode($email = '', $orderCode){
        $orderModel = new orderModel();
        $result['ok'] = false;

//        if(!$email)
//        {
//            $result['error_message'] = 'Vui lòng nhập email!';
//            return $result;
//        }
        if(!$orderCode)
        {
            $result['error_message'] = 'Vui lòng nhập mã đơn hàng!';
            return $result;
        }

        $result['email'] = $email;
        $result['orderCode'] = $orderCode;
        $order = $orderModel->getByOrderCode($orderCode);

//        if(!$order || $order->user->email != $email)
//        {
//            $result['error_message'] = 'Không tồn tại mã đơn hàng: <b>'.$orderCode.'</b> của email:<b>'.$email.'</b>';
//            return $result;
//        }

        $result['order'] = $order;
        $result['ok'] = true;

        return $result;

    }

    /**
     * @param bool $duration
     * @return mixed
     */
    public function getCountOrder($duration = false){
        return $this->_orderModel->getCountOrder($duration);
    }

    /**
     * @param $dateRange
     * @param $type
     * @return mixed
     */
    public function getOrderReport($dateRange, $type){
        if(!$dateRange)
        {
            $startTime = Carbon::now()->subDays(KACANA_REPORT_DURATION_DEFAULT);
            $endTime = Carbon::now();

        }else{
            $dateRange = explode(' - ', $dateRange);
            $startTime = $dateRange[0];
            $endTime = Carbon::createFromFormat('Y-m-d', $dateRange[1])->addDay();
        }


        return $this->_orderModel->reportOrder($startTime, $endTime, $type);
    }

    /**
     * @param $orderId
     * @param $orderDetailId
     */
    public function deleteOrderDetail($orderId, $orderDetailId){
        return $this->_orderDetailModel->deleteOrderDetail($orderId, $orderDetailId);
    }

    /**
     * @param $orderId
     * @param $userId
     * @param $status
     * @return bool
     */
    public function cancelOrder($orderId, $userId, $status){
        $order = $this->_orderModel->getById($orderId);

        if(($order->status == KACANA_ORDER_STATUS_NEW || $order->status == KACANA_ORDER_PARTNER_STATUS_NEW || $order->status == KACANA_ORDER_STATUS_QUICK_ORDER))
        {
            if($status == KACANA_ORDER_PARTNER_STATUS_CANCEL && $order->user_id == $userId)
                $order->updateItem($orderId, ['status' => $status]);
            elseif($status == KACANA_ORDER_STATUS_CANCEL)
                $order->updateItem($orderId, ['status' => $status]);
        }
        else
            return false;

        return true;

    }

    public function exportProductAtStore($orderId){
        $speedSms = new SpeedSms();
        $slack = new Slack();

        $order = $this->_orderModel->getById($orderId);

        if(($order->status == KACANA_ORDER_STATUS_NEW || $order->status == KACANA_ORDER_STATUS_PROCESSING) && $order->order_type == KACANA_ORDER_TYPE_STORE_THD)
        {
            $order->updateItem($orderId, ['status' => KACANA_ORDER_STATUS_COMPLETE]);
            $contentSMS = str_replace('%order_id%', $order->order_code,KACANA_SPEED_SMS_CONTENT_ORDER_PROCESS);
            $contentSMS = str_replace('%user_name%', $this->stripVN($order->addressReceive->name),$contentSMS);

            $this->notificationSlackOrder($orderId);

            $speedSms->sendSMS([$order->addressReceive->phone], $contentSMS);
        }
        else
            return false;

        return true;
    }

    public function notificationSlackOrder($orderId){

        $order = $this->_orderModel->getById($orderId);
        $slack = new Slack();

        if($order->orderType->id == KACANA_ORDER_TYPE_STORE_THD)
            $slackText = 'Thực hiện xuất hàng tại kho: '. $order->orderType->name .' - Tổng: '. formatMoney($order->total);
        else{
            $slackText = 'Thực hiện Ship hàng: '. $order->orderType->name .' - Tổng: '. formatMoney($order->total);
        }


        $attachAddress = [
            'fallback' => 'Địa chỉ nhận hàng',
            'text' => 'Địa chỉ nhận hàng',
            'color' => '#FA5858',
            'fields' => [
                [
                    'title' => 'Người Nhận',
                    'value' => $order->addressReceive->name .' '.$order->addressReceive->phone,
                    'short' => true
                ],
                [
                    'title' => 'Địa chỉ',
                    'value' => $order->address,
                    'short' => true
                ]
            ]
        ];

        $attachProducts = [];

        foreach ($order->orderDetail as $orderDetail){

            $imageUrl = "http://image.kacana.vn".str_replace('%2F', '/', urlencode($orderDetail->product->getOriginal('image')));
            $attachProduct = [
                "color" => "#333",
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

    /**
     * @param $orderId
     * @param $userId
     * @return bool
     */
    public function sendOrder($orderId, $userId)
    {
        $order = $this->_orderModel->getById($orderId);

        if($order->status == KACANA_ORDER_PARTNER_STATUS_NEW && $order->user_id == $userId )
            $order->updateItem($orderId, ['status' => KACANA_ORDER_STATUS_NEW]);
        else
            return false;

        return true;
    }

    /**
     * @param $request
     * @param $userId
     * @param $addressReceiveId
     * @return array
     */
    public function generateAllOrderDetailByUserTable($request, $userId){
        $orderDetailModel = new orderDetailModel();
        $datatables = new DataTables();
        $commissionService = new commissionService();

        $columns = array(
            array( 'db' => 'orders.order_code', 'dt' => 0 ),
            array( 'db' => 'order_detail.name AS order_detail_name', 'dt' => 1 ),
            array( 'db' => 'order_detail.image AS order_detail_image', 'dt' => 2 ),
            array( 'db' => 'order_detail.order_service_status AS order_detail_status', 'dt' => 3 ),
            array( 'db' => 'order_detail.subtotal', 'dt' => 4 ),
            array( 'db' => 'order_detail.updated', 'dt' => 5 ),
            array( 'db' => 'shipping.status AS shipping_status', 'dt' => 6 ),
            array( 'db' => 'partner_payment_detail.payment_id', 'dt' => 7 ),
            array( 'db' => 'order_detail.shipping_service_code', 'dt' => 8 ),
            array( 'db' => 'partner_payments.ref AS payment_code', 'dt' => 9 ),
            array( 'db' => 'orders.id AS order_id', 'dt' => 10 ),
        );

        $return = $orderDetailModel->generateAllOrderDetailByUserTable($request, $columns, $userId);

        if(count($return['data'])) {

            foreach ($return['data'] as &$orderDetail) {
                $orderDetail->order_detail_status = $commissionService::getStatusOrderDetail($orderDetail);

                $orderDetail->subtotal = formatMoney($orderDetail->subtotal);
            }
        }



        $return['data'] = $datatables::data_output( $columns, $return['data'] );

        return $return;
    }

    public function getListOrderType(){
        return $this->_orderTypeModel->getAll();
    }

    public function calculateOrderCurrent($orderId){
        $orderService = new orderService();

        $order = $orderService->getOrderById($orderId);
        $orderDetails = $order->orderDetail;

        $total = 0;
        $discount = 0;
        $originTotal = 0;
        $quantity = 0;

        foreach ($orderDetails as $orderDetail){
                $originTotal += $orderDetail->price * $orderDetail->quantity;
                $total += $orderDetail->subtotal;
                $discount += $orderDetail->discount;
                $quantity += $orderDetail->quantity;
        }

         $dataOrder = [
            'total' => $total,
            'origin_total' => $originTotal,
            'quantity' => $quantity,
            'discount' => $discount
        ];

        return $this->updateOrder($orderId, $dataOrder);
    }

    function stripVN($str) {
        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
        $str = preg_replace("/(đ)/", 'd', $str);

        $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
        $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
        $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
        $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
        $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
        $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
        $str = preg_replace("/(Đ)/", 'D', $str);
        return $str;
    }
}



?>