<?php namespace App\Http\Controllers\Client;

use App\services\addressService;
use App\services\cartService;
use App\services\orderService;
use App\services\userService;
use Illuminate\Http\Request;
use League\Flysystem\Exception;
use Kacana\Client\SpeedSms;

/**
 * Class CheckoutController
 * @package App\Http\Controllers\Client
 */
class CheckoutController extends BaseController {

    public function index(Request $request){
        $cartService = new cartService();
        $addressService = new addressService();
        $userService = new userService();
        $step = $request->get('step', 'login');
        $data = array();

        try{
            $key = '__kacana_user_order__';

            if(\Kacana\Util::isLoggedIn())
            {
                $user = $userService->getUserByEmail($this->_user->email);

                if($step != 'address' && count($user->userAddress))
                {
                    $step = 'choose-address';
                }
                else
                    $step = 'address';

                \Session::set($key, ['email' => $this->_user->email]);
                $data['user'] = $user;
            }
            $data['step'] = $step;
            $cart = $cartService->cartInformation();
            if(!$cart)
                return redirect('/thanh-toan');
            $data['cart'] = $cart;

            $key = '__kacana_user_order__';

            $userOrder = \Session::get($key);

            if($userOrder)
                $data['userOrder'] = $userOrder;

            if($step == 'address' && ($request->isMethod('post') || isset($userOrder['email'])))
            {
                $data['listCity'] = $addressService->getListCity();
                $data['listDistrict'] = $addressService->getListDistrict();
                $data['listWard'] = $addressService->getListWard();

                $email = $request->input('email', false);
                if(isset($userOrder['email']) && !$email) // if refresh page - will check session userOrder
                    $email = $userOrder['email'];

                $password = $request->input('password', false);
                if($password && isEmailAdress($email))
                {
                    return view('client.checkout.checkout', $data);
                }
                elseif($email && isEmailAdress($email))
                {
                    if(!isset($userOrder))
                        $userOrder = array();

                    $userOrder['email'] = $email;
                    \Session::set($key, $userOrder);
                }
                else{
                    $data['errorMessage'] = 'Email không đúng định dạng';
                }
            }
        }
        catch (\Exception $e) {
            if($request->ajax())
            {
                $result['error'] = $e->getMessage();
                return $result;
            }
            else
                return view('errors.404', ['error_message' => $e]);
        }
        return view('client.checkout.checkout', $data);

    }

    public function processOrder(Request $request){
        $cartService = new cartService();
        $orderService = new orderService();
        $speedSms = new SpeedSms();

        $cart = $cartService->cartInformation();
        if(!$cart)
            return view('client.cart.index');
        $key = '__kacana_user_order__';
        $userOrder = \Session::get($key);
        $order = array();
        $order['email'] = (isset($userOrder['email'])?$userOrder['email']:false);
        $order['name'] = $request->get('name', false);
        $order['street'] = $request->get('street', false);
        $order['city_id'] = $request->get('cityId', false);
        $order['district_id'] = $request->get('districtId', false);
        $order['ward_id'] = $request->get('wardId', '');
        $order['phone'] = $request->get('phone', false);
        $checkoutAddressId = $request->get('checkout-address-id', false);

        try{
            if($checkoutAddressId && \Kacana\Util::isLoggedIn())
            {
                $order = $cartService->processCartWithAddressId($this->_user->email, $checkoutAddressId);
            }
            else{
                $order = $cartService->processCart($order);
            }
            $addressReceive = $order->addressReceive;

            $contentSMS = str_replace('%order_id%', $order->order_code,KACANA_SPEED_SMS_CONTENT_NEW_ORDER);
            $contentSMS = str_replace('%user_name%', $addressReceive->name,$contentSMS);
            $speedSms->sendSMS([$addressReceive->phone], $contentSMS);

            \Session::remove($key);
            return view('client.checkout.success', ['order' => $order]);
        }
        catch (\Exception $e) {
            if($request->ajax())
            {
                $result['error'] = $e->getMessage();
                return $result;
            }
            else
                return view('errors.404', ['error_message' => $e]);
        }
    }

    public function processQuickOrder(Request $request){
        $cartService = new cartService();
        $speedSms = new SpeedSms();

        $cart = $cartService->cartInformation();
        if(!$cart)
            return view('client.cart.index');

        $phone = $request->input('phoneQuickOrderNumber', false);
        try{

            $order = $cartService->quickProcessCart($phone);
            $contentSMS = str_replace('%order_id%', $order->order_code,KACANA_SPEED_SMS_CONTENT_NEW_QUICK_ORDER);
            $speedSms->sendSMS([$phone], $contentSMS);
            return view('client.checkout.quick-order-success', ['order' => $order]);
        }
        catch (\Exception $e) {
            if($request->ajax())
            {
                $result['error'] = $e->getMessage();
                return $result;
            }
            else
                return view('errors.404', ['error_message' => $e]);
        }
    }

}
