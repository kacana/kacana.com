<?php namespace App\Http\Controllers\Client;

use App\models\addressReceiveModel;
use App\models\addressCityModel;
use App\models\addressWardModel;
use App\models\orderDetailModel;
use App\models\productGalleryModel;
use App\models\User;
use App\services\productService;
use App\services\cartService;
use App\services\tagService;
use Cart;
use Form;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\CartRequest;
use Illuminate\Http\Request;


/**
 * Class CartController
 * @package App\Http\Controllers\Client
 */
class CartController extends BaseController {


    /**
     * function mame: productDetail
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addProductToCart(Request $request)
    {
        $cartService = new cartService();
        $productService = new productService();

        $result = array();
        $result['ok'] = false;
        try{
            if ($request->isMethod('post')) {
                $productId = $request->get('productId', 0);
                $tagId = $request->get('tagId', 1);
                $colorId = $request->get('colorId', 0);
                $sizeId = $request->get('sizeId', 0);
                $quantity = $request->get('quantity', 1);
                $result['ok'] = true;
                $userId = (\Kacana\Util::isLoggedIn())?$this->_user->id:0;
                $result['item'] = $cartService->addProductToCart($productId, $colorId, $sizeId, $quantity, $tagId);
                $result['products'] = $productService->getProductRelated($tagId, 3, $userId, ['product_tag_type_id' => false]);
                $result['cart'] = $cartService->cartInformation();
            }
        } catch (\Exception $e) {
            if($request->ajax())
            {
                $result['error'] = $e->getMessage();
                return $result;
            }
            else
                return view('errors.404', ['error_message' => $e]);
        }

        return response()->json($result);
    }

    /**
     * load data for cart
     *
     * @param Request $request
     * @return array|\BladeView|bool|\Illuminate\View\View|\Symfony\Component\HttpFoundation\Response
     */
    public function loadCart(Request $request){
        $cartService = new cartService();

        $result = array();
        $result['ok'] = false;

        try{
                $result['ok'] = true;
                $result['cart'] = $cartService->cartInformation();
        } catch (\Exception $e) {
            if($request->ajax())
            {
                $result['error'] = $e->getMessage();
                return $result;
            }
            else
                return view('errors.404', ['error_message' => $e]);
        }

        return response()->json($result);
    }

    /**
     * update Cart item
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateCart(Request $request)
    {
        $cartService = new cartService();

        $rowId = $request->get('rowId', 0);
        $quantity = $request->get('quantity', 0);
        $result = array();
        $result['ok'] = false;

        try{
            $cartService->updateCartItemQuantity($rowId, $quantity);
            $result['ok'] = true;
            $result['cart'] = $cartService->cartInformation();

        } catch (\Exception $e) {
            if($request->ajax())
            {
                $result['error'] = $e->getMessage();
                return $result;
            }
            else
                return view('errors.404', ['error_message' => $e]);
        }
        return response()->json($result);
    }


    /**
     * Action remove cart item
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function removeCart(Request $request)
    {
        $cartService = new cartService();

        $rowId = $request->get('rowId', 0);
        $result = array();
        $result['ok'] = false;

        try{
            $cartService->removeCartItem($rowId);
            $result['ok'] = true;
            $result['cart'] = $cartService->cartInformation();

        } catch (\Exception $e) {
            if($request->ajax())
            {
                $result['error'] = $e->getMessage();
                return $result;
            }
            else
                return view('errors.404', ['error_message' => $e]);
        }
        return response()->json($result);
    }

    /**
     * @return \BladeView|bool|\Illuminate\View\View
     */
    public function showCart()
    {
        $cartService = new cartService();
        $cart = $cartService->cartInformation();
        $total = Cart::total();
        $cities = addressCityModel::lists('name','id');
        $ward = new addressWardModel();
        $wards = $ward->getItemsByCityId(CITY_ID_DEFAULT)->lists('name', 'id');

        return view('client.cart.index', array('cart'=>$cart,'total'=>$total, 'cities'=>$cities, 'wards'=>$wards));
    }

    /*
     * function name processCart
     */
    /**
     * @param CartRequest $request
     */
    public function processCart(CartRequest $request)
    {
        $re = array();
        if(Request::isMethod('post') && $request->all()){
            //save user
            $user = new User();
            $uid = 0;
            $username = "";
            $email = "";
            $existUser = $user->getUserByEmail($request->get('email'));

            if(!empty($existUser)){
                $uid = $existUser->id;
                $username = $existUser->name;
                $email = $existUser->email;
            }else{
                $item = array(
                    'name'  => $request->get('name'),
                    'email' => $request->get('email'),
                    'phone' => $request->get('phone'),
                    'role'  => BUYER
                );
                $createdUser = $user->createItem($item);
                $uid = $createdUser->id;
                $username = $createdUser->name;
                $email = $createdUser->email;
            }

            //save address receive
            $userReceive = new addressReceiveModel();
            $item2 = array(
                'name'      => $request->get('name_2'),
                'phone'     => $request->get('phone_2'),
                'street'    => $request->get('street'),
                'city_id'   => $request->get('city_id'),
                'ward_id'   => $request->get('ward_id')
            );
            $address = $userReceive->createItem($item2);

            if($uid!=0 && $address){
                //create user address
                $userAddress = new UserAddress();
                $option = array('user_id'=>$uid, 'address_id'=>$address->id);
                $userAddress->createItem($option);

                //create order and order detail
                $order = new Order();
                $orderAtt = array(
                    'user_id'       => $uid,
                    'address_id'    => $address->id,
                    'total'         => Cart::total(),
                    'ship'          => 0,
                    'address'       => $address->street . ", " . addressWardModel::showName($address->ward_id) . ", " . addressCityModel::showName($address->city_id),
                );
                $createdOrder = $order->createItem($orderAtt);

                $orderDetail = new OrderDetail();
                if($orderDetail->createItems($createdOrder->id, Cart::content())){
                    //send email
                    $data = array(
                        'username'      => $username,
                        'linkWebsite'   => SITE_LINK,
                        'receiveName'   => $address->name,
                        'receiveAddress'=> $createdOrder->address,
                        'receivePhone'  => $address->phone,
                        'carts'         => Cart::content(),
                        'total'         => Cart::total(),
                    );
                    Cart::destroy();
                    if($this->sendEmailOrder($email, $username, $data)){
                        $re = array('status'=>'ok', 'id'=>$createdOrder->id);
                    }else{
                        $re = array('status'=>'error', 'message' => 'Bị lỗi trong quá trình gửi mail');
                    }
                };
            }
            echo json_encode($re);
        }
    }

    /*
     *
     */
    /**
     * @param $email
     * @param $username
     * @param $data
     * @return bool
     */
    public function sendEmailOrder($email, $username, $data)
    {
        $subject = "Thông tin đặt hàng";
        Mail::send('client.emails.send-email-order', $data, function($message) use($email, $username, $subject){
            $message->to($email, $username)->bcc(ADMIN_EMAIL)->subject($subject);
        });
        return true;
    }

    /**
     * @param Request $request
     * @return \BladeView|bool|\Illuminate\View\View|\Symfony\Component\HttpFoundation\Response
     */
    public function checkout(Request $request){
        $cartService = new cartService();

        $step = $request->get('step', 'login');
        $data = array();

        try{
            $data['step'] = $step;

            if($step == 'login')
            {
                return view('client.checkout.login', $data);
            }


        }
        catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $result['error'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return response()->json($result);

    }

}
