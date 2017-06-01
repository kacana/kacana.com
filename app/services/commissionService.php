<?php namespace App\services;

use App\models\orderModel;
use App\models\orderDetailModel;
use App\models\partnerPaymentDetailModel;
use App\models\partnerPaymentModel;
use App\services\addressService;
use \Kacana\Util;
use Kacana\DataTables;
use Kacana\ViewGenerateHelper;
use Carbon\Carbon;
/**
 * Class shipService
 * @package App\services
 */
class commissionService extends baseService {


    /**
     * @param $orderDetail
     * @return string
     */
    static function getStatusOrderDetail($orderDetail){
        $orderService = new orderService();
        $statusStr = '';
        $order = $orderService->getOrderByOrderCode($orderDetail->order_code);
        if($order->status == KACANA_ORDER_STATUS_CANCEL)
        {
            $statusStr = '<span class="label label-danger">đơn hàng huỷ</span>';
        }
        else
        {
            if($orderDetail->order_detail_status == KACANA_ORDER_SERVICE_STATUS_ORDERED)
                $statusStr = '<span class="label label-info">đã mua hàng</span>';
            elseif($orderDetail->order_detail_status == KACANA_ORDER_SERVICE_STATUS_SOLD_OUT )
                $statusStr = '<span class="label label-danger">hết hàng</span>';
            elseif($orderDetail->order_detail_status == KACANA_ORDER_SERVICE_STATUS_SHIPPING)
            {
                if(isset($orderDetail->payment_id))
                    $statusStr = '<span class="label label-success">đã chuyển tiền </span><br><span class="text-red" >code '.$orderDetail->payment_code.'</span>';
                else{
                    if(!isset($orderDetail->shipping_service_code))
                        $orderDetail->shipping_service_code = '';
                    $statusStr =  \Kacana\ViewGenerateHelper::getStatusDescriptionShip($orderDetail->shipping_status, $orderDetail->shipping_service_code).'<br><span class="text-green" >ship code '.$orderDetail->shipping_service_code.'</span>';
                }
            }
            else
                $statusStr = '<span class="label label-primary">chưa xử lý</span>';
        }

        return $statusStr;
    }

    /**
     * @param $request
     * @param $userId
     * @return array
     */
    public function generateAllCommissionTable($request, $userId){
        $orderDetailModel = new orderDetailModel();
        $datatables = new DataTables();
        $viewHelper = new ViewGenerateHelper();

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
        );

        $return = $orderDetailModel->generateAllCommissionTable($request, $columns, $userId);

        if(count($return['data'])) {

            foreach ($return['data'] as &$orderDetail) {
                $orderDetail->order_detail_status = self::getStatusOrderDetail($orderDetail);

                $orderDetail->subtotal = formatMoney($orderDetail->subtotal * PARTNER_DISCOUNT_PERCENT_LEVEL_1 / 100 );
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
    public function generateTempCommissionTable($request, $userId){
        $orderDetailModel = new orderDetailModel();
        $datatables = new DataTables();
        $viewHelper = new ViewGenerateHelper();

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
        );

        $return = $orderDetailModel->generateTempCommissionTable($request, $columns, $userId);

        if(count($return['data'])) {

            foreach ($return['data'] as &$orderDetail) {

                $orderDetail->order_detail_status = self::getStatusOrderDetail($orderDetail);

                $orderDetail->subtotal = formatMoney($orderDetail->subtotal * PARTNER_DISCOUNT_PERCENT_LEVEL_1 / 100 );
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
    public function generateValidCommissionTable($request, $userId){
        $orderDetailModel = new orderDetailModel();
        $datatables = new DataTables();
        $viewHelper = new ViewGenerateHelper();

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
        );

        $return = $orderDetailModel->generateValidCommissionTable($request, $columns, $userId);

        if(count($return['data'])) {

            foreach ($return['data'] as &$orderDetail) {

                $orderDetail->order_detail_status = self::getStatusOrderDetail($orderDetail);

                $orderDetail->subtotal = formatMoney($orderDetail->subtotal * PARTNER_DISCOUNT_PERCENT_LEVEL_1 / 100 );
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
    public function generatePaymentCommissionTable($request, $userId){
        $orderDetailModel = new orderDetailModel();
        $datatables = new DataTables();
        $viewHelper = new ViewGenerateHelper();

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
        );

        $return = $orderDetailModel->generatePaymentCommissionTable($request, $columns, $userId);

        if(count($return['data'])) {

            foreach ($return['data'] as &$orderDetail) {

                $orderDetail->order_detail_status = self::getStatusOrderDetail($orderDetail);

                $orderDetail->subtotal = formatMoney($orderDetail->subtotal * PARTNER_DISCOUNT_PERCENT_LEVEL_1 / 100 );
            }
        }

        $return['data'] = $datatables::data_output( $columns, $return['data'] );

        return $return;
    }

    /**
     * @param $userId
     * @return array
     */
    public function informationCommission($userId){
        $orderDetailModel = new orderDetailModel();

        $commission = array();

        $allCommission = $orderDetailModel->allCommission($userId);
        $tempCommission = $orderDetailModel->tempCommission($userId);
        $validCommission = $orderDetailModel->validCommission($userId);
        $paymentCommission = $orderDetailModel->paymentCommission($userId);

        $commission['all'] = array_merge(['data' => $allCommission], $this->trimCommission($allCommission));
        $commission['temp'] = array_merge(['data' => $tempCommission], $this->trimCommission($tempCommission));
        $commission['valid'] = array_merge(['data' => $validCommission], $this->trimCommission($validCommission));
        $commission['payment'] = array_merge(['data' => $paymentCommission], $this->trimCommission($paymentCommission));

        return $commission;
    }

    /**
     * @param $commissions
     * @return array
     */
    public function trimCommission($commissions){

        $total = 0;
        $quantity = 0;

        foreach ($commissions as $commission){
            $total += (($commission->subtotal - $commission->discount) * PARTNER_DISCOUNT_PERCENT_LEVEL_1 / 100);
            $quantity += $commission->quantity;
        }

        return ['total' => $total, 'quantity' => $quantity];
    }

    /**
     * @param $request
     * @param $userId
     * @return array
     */
    public function generatePaymentHistoryTable($request, $userId){
        $partnerPaymentModel = new partnerPaymentModel();
        $datatables = new DataTables();
        $viewHelper = new ViewGenerateHelper();

        $columns = array(
            array( 'db' => 'partner_payments.ref', 'dt' => 0 ),
            array( 'db' => 'partner_payments.total AS payment_total', 'dt' => 1 ),
            array( 'db' => 'partner_payment_detail.payment_id', 'dt' => 2 ),
            array( 'db' => 'partner_payments.created_at', 'dt' => 3 ),
            array( 'db' => 'partner_payments.id', 'dt' => 4 )
        );

        $return = $partnerPaymentModel->generatePaymentHistoryTable($request, $columns, $userId);

        if(count($return['data'])) {

            foreach ($return['data'] as &$payment) {
                $payment->payment_id = $payment->count_item_order_detail;
            }
        }

        $return['data'] = $datatables::data_output( $columns, $return['data'] );

        return $return;
    }

    /**
     * @param $request
     * @param $userId
     * @param $addressReceiveId
     * @return array
     */
    public function generateAllCommissionByUserTable($request, $userId, $addressReceiveId){
        $orderDetailModel = new orderDetailModel();
        $datatables = new DataTables();
        $viewHelper = new ViewGenerateHelper();

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
        );

        $return = $orderDetailModel->generateAllCommissionByUserTable($request, $columns, $userId, $addressReceiveId);

        if(count($return['data'])) {

            foreach ($return['data'] as &$orderDetail) {
                $orderDetail->order_detail_status = self::getStatusOrderDetail($orderDetail);

                $orderDetail->subtotal = formatMoney($orderDetail->subtotal * PARTNER_DISCOUNT_PERCENT_LEVEL_1 / 100 );
            }
        }



        $return['data'] = $datatables::data_output( $columns, $return['data'] );

        return $return;
    }

    public function transferPayment($orderDetailIds, $userId, $ref, $note){
        $orderDetailModel = new orderDetailModel();
        $partnerPaymentModel = new partnerPaymentModel();
        $partnerPaymentDetailModel = new partnerPaymentDetailModel();
        $total = 0;
        $dataPartnerPayment = [
            'user_id' => $userId,
            'ref' => $ref,
            'note' => $note,
            'total' => $total
        ];

        $payment = $partnerPaymentModel->createItem($dataPartnerPayment);

        $validCommission = $orderDetailModel->validCommission($userId);
        foreach ($validCommission as $commission){
            if(in_array($commission->id, $orderDetailIds))
            {
                $price = $commission->subtotal*PARTNER_DISCOUNT_PERCENT_LEVEL_1/100;
                $dataPartnerPaymentDetail = [
                    'payment_id' => $payment->id,
                    'order_detail_id' => $commission->id,
                    'total' => $price
                ];
                $total += $price;
                $partnerPaymentDetailModel->createItem($dataPartnerPaymentDetail);
            }
        }

        return $partnerPaymentModel->updateItem($payment->id, ['total' => $total]);

    }

    public function generatePartnerPaymentTable($request){
        $partnerPaymentModel = new partnerPaymentModel();
        $datatables = new DataTables();
        $viewHelper = new ViewGenerateHelper();

        $columns = array(
            array( 'db' => 'partner_payments.ref', 'dt' => 0 ),
            array( 'db' => 'partner_payments.total AS payment_total', 'dt' => 1 ),
            array( 'db' => 'partner_payment_detail.payment_id', 'dt' => 2 ),
            array( 'db' => 'users.name AS user_name', 'dt' => 3 ),
            array( 'db' => 'partner_payments.created_at', 'dt' => 4 ),
            array( 'db' => 'partner_payments.id', 'dt' => 5 )
        );

        $return = $partnerPaymentModel->generatePartnerPaymentTable($request, $columns);

        if(count($return['data'])) {

            foreach ($return['data'] as &$payment) {
                $payment->payment_id = $payment->count_item_order_detail;
            }
        }

        $return['data'] = $datatables::data_output( $columns, $return['data'] );

        return $return;
    }

    public function getPartnerPayment($id){
        $partnerPaymentModel = new partnerPaymentModel();
        return $partnerPaymentModel->getItem($id);
    }
}