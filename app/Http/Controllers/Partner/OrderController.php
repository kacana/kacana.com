<?php namespace App\Http\Controllers\Partner;

use App\services\addressService;
use App\services\productService;
use App\services\shipService;
use Illuminate\Http\Request;
use App\services\orderService;

class OrderController extends BaseController {

    public function index($domain){
        $addressService = new addressService();
        $data = array();

        $data['listCity'] = $addressService->getListCity();
        $data['listDistrict'] = $addressService->getListDistrict();

        return view('partner.order.index', $data);
    }

    public function generateOrderTable(Request $request){
        $params = $request->all();
        $orderService = new orderService();

        try {
            $return = $orderService->generateOrderTableByUserId($params, $this->_user->id);

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
    public function edit($domain, Request $request,$code){
        $orderService = new orderService();
        $addressService = new addressService();
        $shipService = new shipService();
        try {
            $order = $orderService->getOrderByOrderCode($code);
            $id = $order->id;
            if($order->user_id != $this->_user->id)
                return redirect('/order');

            if($request->isMethod('PUT')){
                if($order->user_id == $this->_user->id && $order->status == KACANA_ORDER_PARTNER_STATUS_NEW)
                    $addressService->updateAddressReceive($request->all());
            }

            $buyer = $order->user;
            $user_address = $order->addressReceive;

            $hubInfos = $shipService->getPickHubs();

            $mainHub = $shipService->getPickHubMain($hubInfos);
            $serviceList = $shipService->getServiceList($user_address->district->code,  $mainHub->DistrictCode);
            $shippingServiceInfos = $shipService->calculateServiceFee($user_address->district->code, $mainHub->DistrictCode, $serviceList);

            $cities = $addressService->getListCity()->lists('name', 'id');
            $wards = $addressService->getListWardByDistrictId($user_address->district_id);
            $districts = $addressService->getListDistrict();
            return view('partner.order.edit', compact('order', 'buyer', 'user_address', 'cities', 'districts', 'wards', 'shippingServiceInfos', 'hubInfos'));
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

    public function searchAddressDelivery(Request $request){
        $addressService = new addressService();

        $search = $request->input('search');
        $type = $request->input('type');
        $return['ok'] = 0;
        try{
            $return['items'] = $addressService->searchAddressDelivery($search, $type, $this->_user->id);
            $return['ok'] = 1;
        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }
        return response()->json($return);

    }

    public function createOrder(Request $request){
        $addressService = new addressService();
        $orderService = new orderService();

        $deliveryId = $request->input('deliveryId',0);
        $deliveryName = $request->input('deliveryName','');
        $deliveryPhone = $request->input('deliveryPhone','');
        $cityId = $request->input('cityId','');
        $districtId = $request->input('districtId','');
        $wardId = $request->input('wardId','');
        $deliveryStreet = $request->input('deliveryStreet','');
        $deliveryEmail = $request->input('deliveryEmail','');

        try{
            if(!intval($deliveryId))
            {
                $deliveryAddress = [];
                $deliveryAddress['name'] = $deliveryName;
                $deliveryAddress['email'] = $deliveryEmail;
                $deliveryAddress['phone'] = $deliveryPhone;
                $deliveryAddress['street'] = $deliveryStreet;
                $deliveryAddress['city_id'] = $cityId;
                $deliveryAddress['district_id'] = $districtId;
                $deliveryAddress['ward_id'] = $wardId;

                $addressReceive = $addressService->createUserAddress($this->_user->id, $deliveryAddress);
                $deliveryId = $addressReceive->id;
            }

            $order = $orderService->createOrder($this->_user->id, $deliveryId, 0, 0, 0, 0, KACANA_ORDER_PARTNER_STATUS_NEW);

            return redirect('/order/edit/'.$order->order_code);
        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }
        return response()->json($return);
    }

    public function updateOrderDetail($domain, $orderId, $orderDetailId, Request $request){
        $orderService = new orderService();

        $order = $orderService->getOrderById($orderId);
        $orderDetails = $order->orderDetail;
        $orderDetailProperty = $request->input('product-properties', '');
        $orderDetailQuantity = $request->input('product-quantity', 0);

        $total = 0;
        $discount = 0;
        $originTotal = 0;
        $quantity = 0;

        try{

            foreach ($orderDetails as $orderDetail){
                if($orderDetail->id == $orderDetailId)
                {
                    $orderDetailDiscount = $orderDetail->discount*$orderDetailQuantity;

                    $orderDetailProperty = explode('-', $orderDetailProperty);
                    $dataOrderDetail = [
                        'color_id'=>$orderDetailProperty[0],
                        'size_id'=>isset($orderDetailProperty[1])?$orderDetailProperty[1]:'',
                        'quantity' => $orderDetailQuantity,
                        'subtotal' => $orderDetail->price * $orderDetailQuantity - $orderDetailDiscount
                    ];
                    $orderService->updateOrderDetail($orderDetailId, $dataOrderDetail);

                    $originTotal += $orderDetail->price * $orderDetailQuantity;
                    $total += $orderDetail->price * $orderDetailQuantity - $orderDetailDiscount;
                    $discount += $orderDetailDiscount;
                    $quantity += $orderDetailQuantity;

                }
                else
                {
                    $originTotal += $orderDetail->price * $orderDetail->quantity;
                    $total += $orderDetail->subtotal;
                    $discount += $orderDetail->discount;
                    $quantity += $orderDetail->quantity;
                }
            }

            $dataOrder = [
                'total' => $total,
                'origin_total' => $originTotal,
                'quantity' => $quantity,
                'discount' => $discount
            ];

            $orderService->updateOrder($orderId, $dataOrder);

            return redirect('/order/edit/'.$order->order_code);

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

    public function searchProduct(Request $request){
        $productService = new productService();
        $search = $request->input('search', '');
        $return['ok'] = 0;

        try{
            $return['ok'] = 1;
            $return['data'] = $productService->searchProductByName($search);
        } catch (\Exception $e) {
            if($request->ajax())
            {
                $result['error'] = $e->getMessage();
                return $result;
            }
            else
                return view('errors.404', ['error_message' => $e]);
        }

        return response()->json($return);
    }

    public function addProductToOrder(Request $request){
        $productService = new productService();
        $orderService = new orderService();

        $orderId = $request->input('orderId');
        $productId = $request->input('productId');

        try{
            $order = $orderService->getOrderById($orderId);
            $total = $order->total;
            $discount = $order->discount;
            $originTotal = $order->origin_total;
            $quantity = $order->quantity;

            $product = $productService->getProductById($productId);

            $productDiscount = 0;

            if($product->mainDiscount)
                $productDiscount = $product->mainDiscount;
            elseif ($product->discount)
                $productDiscount = $product->discount;

            $orderDetailData = new \stdClass();

            $orderDetailData->order_id =  $orderId;
            $orderDetailData->name = $product->name;
            $orderDetailData->price = $product->sell_price;
            $orderDetailData->discount = $product->discount;
            $orderDetailData->quantity = 1;
            $orderDetailData->product_id = $product->id;;
            $orderDetailData->product_url = urlProductDetail($product);
            $orderDetailData->image = $product->image;
            $orderDetailData->subtotal = $product->sell_price - $productDiscount;
            $orderService->createOrderDetailAdmin($orderDetailData);

            $total += $product->sell_price - $productDiscount;
            $discount += $productDiscount;
            $originTotal += $product->sell_price;
            $quantity +=1;

            $dataOrder = [
                'total' => $total,
                'origin_total' => $originTotal,
                'quantity' => $quantity,
                'discount' => $discount
            ];

            $orderService->updateOrder($orderId, $dataOrder);

            return redirect('/order/edit/'.$order->order_code);

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

    public function deleteOrderDetail(Request $request){
        $orderService = new orderService();

        $orderId = $request->input('orderId');
        $orderDetailId = $request->input('orderDetailId');

        try{


            $order = $orderService->getOrderById($orderId);
            $orderDetail = $orderService->getOrderDetailById($orderDetailId);

            $originTotal = $order->origin_total - ($orderDetail->price * $orderDetail->quantity);
            $total = $order->total - $orderDetail->subtotal;
            $discount = $order->discount - $orderDetail->discount;
            $quantity = $order->quantity - $orderDetail->quantity;

            $dataOrder = [
                'total' => $total,
                'origin_total' => $originTotal,
                'quantity' => $quantity,
                'discount' => $discount
            ];

            $orderService->updateOrder($orderId, $dataOrder);

            $orderService->deleteOrderDetail($orderId, $orderDetailId);

            return redirect('/order/edit/'.$order->order_code);

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

    public function getWardByDistrictId(Request $request){
        $addressService = new addressService();

        $districtId = $request->input('districtId');
        $result['ok'] = 0;
        try{
            $result['data'] = $addressService->getListWardByDistrictId($districtId);
            $result['ok'] = 1;
        }
        catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $result['error'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return response()->json($result);
    }

    public function cancelOrder(Request $request){
        $orderService = new orderService;
        $addressService = new addressService();

        $orderId = $request->input('orderId', 0);

        try {
            $return['data'] = $orderService->cancelOrder($orderId, $this->_user->id, KACANA_ORDER_PARTNER_STATUS_CANCEL);
            $return['ok'] = 1;

        } catch (\Exception $e) {
            if($request->ajax())
            {
                $result['error'] = $e->getMessage();
                return $result;
            }
            else
                return view('errors.404', ['error_message' => $e->getMessage()]);
        }

        return redirect('/order');
    }

    public function sendOrder(Request $request){
        $orderService = new orderService;
        $addressService = new addressService();

        $orderId = $request->input('orderId', 0);
        $order = $orderService->getOrderById($orderId);
        try {
            $return['data'] = $orderService->sendOrder($orderId, $this->_user->id);
            $return['ok'] = 1;

        } catch (\Exception $e) {
            if($request->ajax())
            {
                $result['error'] = $e->getMessage();
                return $result;
            }
            else
                return view('errors.404', ['error_message' => $e->getMessage()]);
        }

        return redirect('/order/edit/'.$order->order_code);
    }
}
