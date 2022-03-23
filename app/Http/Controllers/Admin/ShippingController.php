<?php namespace App\Http\Controllers\Admin;

use App\services\addressService;
use App\services\shipGhnService;
use App\services\shipGhtkService;
use App\services\shipSuperShipService;
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
        $shipSuperShipService = new shipSuperShipService();
        $orderService = new orderService();
        $a = [];

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
            {
                $ship = $shipGhtkService->createShippingOrder($orderDetailIds,
                    $orderId,
                    0,
                    $weight,
                    $originShipFee,
                    $shipFee,
                    $extraDiscount,
                    $extraDiscountDesc,
                    $paid);

                if (isset($ship->success) && $ship->success) {
                    $orderService->notificationSlackOrder($orderId);
                    return redirect('/shipping/detail?id=' . $ship->order->label . '&type=' . KACANA_SHIP_TYPE_SERVICE_GHTK);
                } else {
                    return redirect('/order/edit/'.$orderId.'?message='.$ship->message);
                }

            }
            elseif($shippingServiceTypeId == KACANA_SHIP_TYPE_ID_SUPER_SHIP)
            {
                $ship = $shipSuperShipService->createShippingOrder($orderDetailIds,
                    $orderId,
                    0,
                    $weight,
                    $originShipFee,
                    $shipFee,
                    $extraDiscount,
                    $extraDiscountDesc,
                    $paid);

                $orderService->notificationSlackOrder($orderId);
                return redirect('/shipping/detail?id='.$ship->order->label.'&type='.KACANA_SHIP_TYPE_SERVICE_GHTK);
            }
            else
            {
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
                if($ship)
                {
                    $orderService->notificationSlackOrder($orderId);
                    return redirect('/shipping/detail?id='.$ship->OrderCode.'&type='.KACANA_SHIP_TYPE_SERVICE_GHN);
                }
                else
                    return redirect('/order/edit/'.$orderId);
            }
        } catch (\Exception $e) {
            echo $e->getTraceAsString();
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
        $shipGhtKService = new shipGhtkService();

        $shippingId =  $request->input('id');

        try {
            $shipping = $shipGhnService->getShippingById($shippingId);
            if ($shipping->ship_service_type == KACANA_SHIP_TYPE_SERVICE_GHN) {
                $status = $shipGhnService->GetOrderInfoStatus($shippingId);
            } elseif ($shipping->ship_service_type == KACANA_SHIP_TYPE_SERVICE_GHTK) {
                $status = $shipGhtKService->GetOrderInfoStatus($shippingId);
            }

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
                $discount += $orderDetail->discount * $orderDetail->quantity;
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

    public function printBarcode(Request $request){
        $shipGhnService = new shipGhnService();
        $shippingId =  $request->input('id');
        $ship = $shipGhnService->getShippingById($shippingId);
        $userAddress = $ship->addressReceive;

        $shippingIds = explode('.', $shippingId);
        $shippingIdExtra = '';
        if(count($shippingIds) == 4)
        {
            $shippingId = $shippingIds[0].'.'.$shippingIds[1];
            $shippingIdExtra = $shippingIds[2].'.'.$shippingIds[3];
        }


        return view('admin.shipping.print_barcode', array('ship'=> $ship,'userAddress' => $userAddress, 'shippingId'=> $shippingId, 'shippingIdExtra' => $shippingIdExtra));
    }
}
