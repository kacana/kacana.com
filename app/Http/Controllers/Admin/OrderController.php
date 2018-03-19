<?php namespace App\Http\Controllers\Admin;

use App\services\addressService;
use App\services\orderFromService;
use App\services\productService;
use App\services\shipGhnService;
use App\services\shipGhtkService;
use Illuminate\Http\Request;
use App\services\orderService;

class OrderController extends BaseController {

    public function index($domain){
        $addressService = new addressService();
        $orderService = new orderService();
        $data = array();

        $data['listCity'] = $addressService->getListCity();
        $data['listDistrict'] = $addressService->getListDistrict();
        $data['listDistrict'] = $addressService->getListDistrict();
        $data['listOrderType'] = $orderService->getListOrderType();

        return view('admin.order.index', $data);
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
        $orderFromService = new orderFromService();
        $addressService = new addressService();
        $shipGhnService = new shipGhnService();
        $shipGhtkService = new shipGhtkService();

        try {
            if($request->isMethod('PUT')){
                $addressService->updateAddressReceive($request->all());
                $newAddressOrder = $request->input('street', '');
                $orderService->updateOrder($id, ['address' => $newAddressOrder]);
            }
            $order = $orderService->getOrderById($id);
            $buyer = $order->user;
            $user_address = $order->addressReceive;

            $hubInfos = $shipGhnService->getPickHubs();

            $mainHub = $shipGhnService->getPickHubMain($hubInfos);
            if($user_address->district_id )
            {
                $pickDistrictCode = 0;
                if (isset($mainHub->DistrictCode))
                {
                    $pickDistrictCode = $mainHub->DistrictCode;
                    $serviceList = $shipGhnService->getServiceList($user_address->district->code,  $mainHub->DistrictCode);
                    $shippingServiceInfos = $shipGhnService->calculateServiceFee($user_address->district->code, $mainHub->DistrictCode, $serviceList);
                }

                $wards = $addressService->getListWardByDistrictId($user_address->district_id);
                $feeGhtk = $shipGhtkService->calculateFee($pickDistrictCode, $user_address, $order->total);
            }
            $orderFroms = $orderFromService->getListOrderFrom();
            $cities = $addressService->getListCity()->lists('name', 'id');
            $districts = $addressService->getListDistrict();
            return view('admin.order.edit', compact('order', 'buyer', 'user_address', 'cities', 'districts', 'wards', 'shippingServiceInfos', 'hubInfos', 'feeGhtk', 'orderFroms'));
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
        $shipGhtkService = new shipGhtkService();
        $shipGhnService = new shipGhnService();

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
            $serviceList = $shipGhnService->getServiceList($user_address->district->code,  $pickDistrictCode);
            $results['serviceGhn'] = $shipGhnService->calculateServiceFee($user_address->district->code, $pickDistrictCode, $serviceList, $weight, $length, $width, $height);
            $results['serviceGhtk'] = $shipGhtkService->calculateFee($pickDistrictCode, $user_address, $weight);
            $return['data'] = $results;

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

    public function searchAddressDelivery(Request $request){
        $addressService = new addressService();

        $search = $request->input('search');
        $type = $request->input('type');
        $return['ok'] = 0;
        try{
            $return['items'] = $addressService->searchAddressDelivery($search, $type);
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
        $orderType = $request->input('orderType', KACANA_ORDER_TYPE_ONLINE);

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

                $addressReceive = $addressService->createUserAddress(KACANA_USER_SYSTEM_ORDER_ID, $deliveryAddress);
                $deliveryId = $addressReceive->id;
            }

            $order = $orderService->createOrder(KACANA_USER_SYSTEM_ORDER_ID, $deliveryId, 0, 0, 0, 0, KACANA_ORDER_STATUS_NEW, $orderType);

            return redirect('/order/edit/'.$order->id);
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
        $orderDetailDiscount = $request->input('product-discount', 0);
        $orderDetailQuantity = $request->input('product-quantity', 0);
        $orderDetailFrom = $request->input('order-from-id', 0);
        $orderDetailDiscountType = $request->input('discount-type', 0);
        $orderDetailDiscountRef = $request->input('discount-ref', 0);

        $total = 0;
        $discount = 0;
        $originTotal = 0;
        $quantity = 0;

        try{

            foreach ($orderDetails as $orderDetail){
                if($orderDetail->id == $orderDetailId)
                {
                    $orderDetailProperty = explode('-', $orderDetailProperty);
                    $dataOrderDetail = [
                        'color_id'=>$orderDetailProperty[0],
                        'size_id'=>isset($orderDetailProperty[1])?$orderDetailProperty[1]:'',
                        'discount_ref'=> $orderDetailDiscountRef,
                        'discount_type'=> $orderDetailDiscountType,
                        'quantity' => $orderDetailQuantity,
                        'subtotal' => calculateDiscountPrice($orderDetail->price, $orderDetailDiscountType, $orderDetailDiscountRef) * $orderDetailQuantity,
                        'order_from_id' => $orderDetailFrom
                    ];
                    $orderService->updateOrderDetail($orderDetailId, $dataOrderDetail);
                }
            }

            $orderService->calculateOrderCurrent($orderId);

            return redirect('/order/edit/'.$orderId);

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
            $return['data'] = $productService->searchProductByNameForAdmin($search);
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
        $productId = $request->input('productId', 0);
        $propertyId = intval($request->input('propertyId', 0));


        try{
            $order = $orderService->getOrderById($orderId);


            if($productId)
                $product = $productService->getProductById($productId, 0, false);
            else
            {
                $propertyProduct = $productService->getProductProperty($propertyId);
                $product = $propertyProduct->product;
            }

            $productDiscount = 0;

            if($product->mainDiscount)
                $productDiscount = $product->mainDiscount;
            elseif ($product->discount)
                $productDiscount = $product->discount;

            $orderDetailData = new \stdClass();

            $orderDetailData->order_id =  $orderId;
            $orderDetailData->name = $product->name;
            $orderDetailData->price = $product->sell_price;
            $orderDetailData->discount = $productDiscount;
            $orderDetailData->quantity = 1;
            $orderDetailData->product_id = $product->id;;
            $orderDetailData->product_url = urlProductDetail($product);

            $orderDetailData->subtotal = $product->sell_price - $productDiscount;
            $orderDetailData->image = $product->image;

            if(isset($propertyProduct)){
                if($propertyProduct->product_gallery_id)
                    $orderDetailData->image = $propertyProduct->gallery->image;

                if($propertyProduct->color_id)
                    $orderDetailData->color_id = $propertyProduct->color->id;
                if($propertyProduct->size_id)
                    $orderDetailData->color_id = $propertyProduct->size->id;
            }

            $orderService->createOrderDetailAdmin($orderDetailData);

            $orderService->calculateOrderCurrent($orderId);
            return redirect('/order/edit/'.$orderId);

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
            $orderService->deleteOrderDetail($orderId, $orderDetailId);
            $orderService->calculateOrderCurrent($orderId);

            return redirect('/order/edit/'.$orderId);

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
            $return['data'] = $orderService->cancelOrder($orderId, $this->_user->id, KACANA_ORDER_STATUS_CANCEL);
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

    public function exportProductAtStore(Request $request){
        $orderService = new orderService;
        $orderId = $request->input('orderId', 0);
        if($orderService->exportProductAtStore($orderId))
            return response()->json(['ok' => 1]);
    }
}
