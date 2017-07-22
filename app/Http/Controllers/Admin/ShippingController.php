<?php namespace App\Http\Controllers\Admin;

use App\services\addressService;
use App\services\shipGhnService;
use App\services\shipGhtkService;
use Illuminate\Http\Request;
use App\services\orderService;
use Kacana\ViewGenerateHelper;

class ShippingController extends BaseController {

    public function index(){
        return view('admin.shipping.index');
    }

    public function createShipping(Request $request){
        $shipGhnService = new shipGhnService();
        $shipGhtkService = new shipGhtkService();
        $orderId = $request->input('orderId');
        $orderDetailIds = $request->input('orderDetailId');
        $pickHubId = $request->input('pickHubId', 0);
        $shippingServiceTypeId = $request->input('shippingServiceTypeId', 0);

        $shipFee = $request->input('shipFee', 0);
        $paid = $request->input('paid', 0);
        $originShipFee = $request->input('originShipFee', 0);
        $extraDiscount = $request->input('extraDiscount', 0);
        $extraDiscountDesc = $request->input('extraDiscountDesc', '');
        $OrderClientNote = $request->input('OrderClientNote', '');
        $OrderContentNote = $request->input('OrderContentNote', '');

        $weight = $request->input('Weight', KACANA_SHIP_DEFAULT_WEIGHT);
        $length = $request->input('Length', KACANA_SHIP_DEFAULT_LENGTH);
        $width = $request->input('Width', KACANA_SHIP_DEFAULT_WIDTH);
        $height = $request->input('Height', KACANA_SHIP_DEFAULT_HEIGHT);

        try{
            if($shippingServiceTypeId == KACANA_SHIP_TYPE_ID_GHTK)
                $ship = $shipGhtkService->createShippingOrder($orderDetailIds,
                    $orderId,
                    $shippingServiceTypeId,
                    $pickHubId,
                    $weight,
                    $length,
                    $width,
                    $height,
                    $originShipFee,
                    $shipFee,
                    $extraDiscount,
                    $extraDiscountDesc,
                    $OrderClientNote,
                    $OrderContentNote,
                    $paid);
            else
                $ship = $shipGhnService->createShippingOrder($orderDetailIds,
                    $orderId,
                    $shippingServiceTypeId,
                    $pickHubId,
                    $weight,
                    $length,
                    $width,
                    $height,
                    $originShipFee,
                    $shipFee,
                    $extraDiscount,
                    $extraDiscountDesc,
                    $OrderClientNote,
                    $OrderContentNote,
                    $paid);

            return redirect('/shipping/detail?id='.$ship->OrderCode);
        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }
    }

    public function generateShippingTable(Request $request){
        $params = $request->all();
        $shipGhnService = new shipGhnService();

        try {
            $return = $shipGhnService->generateShippingTable($params);

        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return response()->json($return);
    }

    public function detail(Request $request){

        $orderService = new orderService();
        $addressService = new addressService();
        $shipGhnService = new shipGhnService();

        $shippingId =  $request->input('id');

        try {

            $status = $shipGhnService->GetOrderInfoStatus($shippingId);
            $ship =  $shipGhnService->updateShippingStatus($shippingId, $status);
            $ship->statusDesc = ViewGenerateHelper::getStatusDescriptionShip($status, $shippingId);

            $user_address = $ship->addressReceive;
            $cities = $addressService->getListCity()->lists('name', 'id');
            $districts = $addressService->getListDistrict();

            return view('admin.shipping.detail', compact('ship', 'user_address', 'cities', 'districts'));
        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

    }

    public function printOrder(Request $request){
        $orderService = new orderService();
        $addressService = new addressService();
        $shipGhnService = new shipGhnService();

        $shippingId =  $request->input('id');

        try {
            $ship =  $shipGhnService->getShippingById($shippingId);

            $user_address = $ship->addressReceive;
            $cities = $addressService->getListCity()->lists('name', 'id');
            $districts = $addressService->getListDistrict();
            $origin_total = 0;
            $discount = 0;
            foreach ($ship->orderDetail as $orderDetail){
                $origin_total += $orderDetail->price * $orderDetail->quantity;
                $discount += $orderDetail->discount;
            }
            $ship->origin_total = $origin_total;
            $ship->discount = $discount;
            return view('admin.shipping.print_order', compact('ship', 'user_address'));
        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }
    }

    public function printOrderStore(Request $request){
        $orderService = new orderService();
        $addressService = new addressService();
        $shipGhnService = new shipGhnService();

        $orderId =  $request->input('id');

        try {
            $order =  $orderService->getOrderById($orderId);

            $user_address = $order->addressReceive;
            $user = $this->_user;
            $origin_total = 0;
            $discount = 0;

            foreach ($order->orderDetail as $orderDetail){
                $origin_total += $orderDetail->price * $orderDetail->quantity;
                $discount += $orderDetail->discount;
            }
            $order->origin_total = $origin_total;
            $order->discount = $discount;

            return view('admin.shipping.print_order_store', compact('order', 'user', 'user_address'));
        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }
    }
}
