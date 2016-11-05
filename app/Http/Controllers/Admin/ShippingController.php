<?php namespace App\Http\Controllers\Admin;

use App\services\addressService;
use App\services\shipService;
use Illuminate\Http\Request;
use App\services\orderService;
use Kacana\ViewGenerateHelper;

class ShippingController extends BaseController {

    public function index(){
        return view('admin.shipping.index');
    }

    public function createShipping(Request $request){
        $shipService = new shipService();
        $orderId = $request->input('orderId');
        $orderDetailIds = $request->input('orderDetailId');
        $pickHubId = $request->input('pickHubId', KACANA_SHIP_STORE_MAIN_ID);
        $shippingServiceTypeId = $request->input('shippingServiceTypeId', 0);

        $shipFee = $request->input('shipFee', 0);
        $paid = $request->input('paid', 0);
        $originShipFee = $request->input('originShipFee', 0);
        $extraDiscount = $request->input('extraDiscount', 0);
        $extraDiscountDesc = $request->input('extraDiscountDesc', '');

        $weight = $request->input('Weight', KACANA_SHIP_DEFAULT_WEIGHT);
        $length = $request->input('Length', KACANA_SHIP_DEFAULT_LENGTH);
        $width = $request->input('Width', KACANA_SHIP_DEFAULT_WIDTH);
        $height = $request->input('Height', KACANA_SHIP_DEFAULT_HEIGHT);

        try{
            $ship = $shipService->createShippingOrder($orderDetailIds, $orderId, $shippingServiceTypeId, $pickHubId, $weight, $length, $width, $height, $originShipFee, $shipFee, $extraDiscount, $extraDiscountDesc, $paid);
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
        $shipService = new shipService();

        try {
            $return = $shipService->generateShippingTable($params);

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
        $shipService = new shipService();

        $shippingId =  $request->input('id');

        try {

            $status = $shipService->GetOrderInfoStatus($shippingId);
            $ship =  $shipService->updateShippingStatus($shippingId, $status);
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
        $shipService = new shipService();

        $shippingId =  $request->input('id');

        try {
            $ship =  $shipService->getShippingById($shippingId);

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
}
