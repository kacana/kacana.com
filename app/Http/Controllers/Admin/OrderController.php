<?php namespace App\Http\Controllers\Admin;

use App\services\addressService;
use App\services\shipService;
use Illuminate\Http\Request;
use App\services\orderService;

class OrderController extends BaseController {

    public function index($domain){

        return view('admin.order.index');
    }

    public function generateOrderTable(Request $request){
        $params = $request->all();
        $orderService = new orderService();

        try {
            $return = $orderService->generateOrderTable($params);

        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return response()->json($return);
    }

    /*
     * Edit order
     *
     * @param int $id
     * @return Response
     */
    public function edit($domain, Request $request,$id){
        $orderService = new orderService();
        $addressService = new addressService();
        $shipService = new shipService();
        try {
            if($request->isMethod('PUT')){
                $addressService->updateAddressReceive($request->all());
            }
            $order = $orderService->getOrderById($id);
            $buyer = $order->user;
            $user_address = $order->addressReceive;

            $hubInfos = $shipService->getPickHubs();
            $mainHub = $shipService->getPickHubMain($hubInfos);
            $serviceList = $shipService->getServiceList($user_address->district->code,  $mainHub->DistrictCode);
            $shippingServiceInfos = $shipService->calculateServiceFee($user_address->district->code, $mainHub->DistrictCode, $serviceList);

            $cities = $addressService->getListCity()->lists('name', 'id');
            $wards = $addressService->getListWard()->lists('name', 'id');
            $districts = $addressService->getListDistrict();
            return view('admin.order.edit', compact('order', 'buyer', 'user_address', 'cities', 'districts', 'wards', 'shippingServiceInfos', 'hubInfos'));
        } catch (\Exception $e) {
            if($request->ajax())
            {
                $result['error'] = $e->getMessage();
                return $result;
            }
            else
                return view('errors.404', ['error_message' => $e]);
        }
    }

    public function checkFeeShipping(Request $request){
        $orderService = new orderService();
        $addressService = new addressService();
        $shipService = new shipService();

        $weight = $request->input('weight', KACANA_SHIP_DEFAULT_WEIGHT);
        $length = $request->input('length', KACANA_SHIP_DEFAULT_LENGTH);
        $width = $request->input('width', KACANA_SHIP_DEFAULT_WIDTH);
        $height = $request->input('height', KACANA_SHIP_DEFAULT_HEIGHT);
        $orderId = $request->input('orderId', 0);
        $pickDistrictCode = $request->input('pickDistrictCode', 0);

        $return['ok'] = 0;

        try{
            $order = $orderService->getOrderById($orderId);
            $user_address = $order->addressReceive;
            $serviceList = $shipService->getServiceList($user_address->district->code,  $pickDistrictCode);

            $return['data'] = $shipService->calculateServiceFee($user_address->district->code, $pickDistrictCode, $serviceList, $weight, $length, $width, $height);

            $return['ok'] = 1;
        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return response()->json($return);
    }

    public function updateOrderService(Request $request){
        $params = $request->all();
        $orderService = new orderService();
        $return['ok'] = 0;
        try {
            $return['ok'] = 1;
            $return['data'] = $orderService->updateOrderDetail($params['id'], $params);

        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart

            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return response()->json($return);
    }

    public function getOrderDetailisOrdered(Request $request){
        $orderService = new orderService();

        $orderId = $request->input('orderId');
        $addressId = $request->input('addressId');
        $return['ok'] = 0;
        try {
            $return['ok'] = 1;
            $return['order'] = $orderService->getOrderById($orderId);
            $return['addressReceive'] = $orderService->getOrderById($orderId)->addressReceive;
            $return['data'] = $orderService->getOrderDetailisOrdered($orderId, $addressId);
        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return response()->json($return);
    }

    public function shipping(Request $request){

        $shipService = new shipService();

        $orderId = $request->input('orderId');
        $orderDetailIds = $request->input('orderDetailId');
        $pickHubId = $request->input('pickHubId', KACANA_SHIP_STORE_MAIN_ID);
        $shippingServiceTypeId = $request->input('shippingServiceTypeId', 0);
        $ExpectedDeliveryTime = $request->input('ExpectedDeliveryTime', '');

        $weight = $request->input('Weight', KACANA_SHIP_DEFAULT_WEIGHT);
        $length = $request->input('Length', KACANA_SHIP_DEFAULT_LENGTH);
        $width = $request->input('Width', KACANA_SHIP_DEFAULT_WIDTH);
        $height = $request->input('Height', KACANA_SHIP_DEFAULT_HEIGHT);


        try{
            $ship = $shipService->createShippingOrder($orderDetailIds, $orderId, $shippingServiceTypeId, $pickHubId, $weight, $length, $width, $height, $ExpectedDeliveryTime);

        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return response()->json($return);
    }

}
