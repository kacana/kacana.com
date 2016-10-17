<?php namespace App\Http\Controllers\Client;

use App\services\addressService;
use App\services\orderService;
use App\services\userService;
use Auth;
use Illuminate\Http\Request;
use Kacana\Util;
/**
 * Class CustomerController
 * @package App\Http\Controllers\Client
 */
class CustomerController extends BaseController {

    /**
     * @param Request $request
     * @return \BladeView|bool|\Illuminate\View\View
     */
    public function trackingOrder(Request $request){
        $orderService = new orderService();
        try{
            $email = $request->input('email', false);
            $orderCode = $request->input('orderCode', false);

            if($email && $orderCode)
            {
                $email = $request->input('email');
                $orderCode = $request->input('orderCode');

                $result = $orderService->checkTrackingOrderCode($email, $orderCode);
                if(!$result['ok']){
                    return view('client.customer.tracking-order', $result);
                }
                else{
                    return view('client.customer.detail-tracking-order', $result);
                }
            }

            return view('client.customer.tracking-order');
        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }
    }

    /**
     * @param Request $request
     * @return \BladeView|bool|\Illuminate\View\View
     */
    public function account(Request $request){
        $orderService = new orderService();
        $utils = new Util();
        try{
            $user = $utils->getCurrentUser();
            if($request->isMethod('post'))
            {

            }
            return view('client.customer.account', ['user'=>$user]);
        } catch (\Exception $e) {
            $return['error'] = $e->getMessage();
        }
    }

    /**
     * @param Request $request
     * @return \BladeView|bool|\Illuminate\View\View
     */
    public function accountUpdateInformation(Request $request){
        $userService = new userService();

        $name = $request->input('name');
        $phone = $request->input('phone');
        $userId = $this->_user->id;
        try{

            $result = $userService->accountUpdateInformation($userId, $name, $phone);
            Auth::user()->name = $name;
            Auth::user()->phone = $phone;

            return view('client.customer.account', ['user'=>Auth::user(), 'accountUpdateInformation'=>$result]);

        } catch (\Exception $e) {
            $return['error'] = $e->getMessage();
        }
    }

    /**
     * @param Request $request
     * @return \BladeView|bool|\Illuminate\View\View
     */
    public function accountUpdatePassword(Request $request){
        $userService = new userService();

        $currentPassword = $request->input('currentPassword');
        $password = $request->input('password');
        $confirmPassword = $request->input('confirmPassword');
        try{

            $result = $userService->accountUpdatePassword($this->_user, $currentPassword, $password, $confirmPassword);

            return view('client.customer.account', ['user'=>Auth::user(), 'accountUpdatePassword'=>$result]);

        } catch (\Exception $e) {
            $return['error'] = $e->getMessage();
        }
    }

    public function myOrder(Request $request){
        $userService = new userService();
        try{
            $user = $userService->getUserByEmail($this->_user->email);

            return view('client.customer.my-order', ['user'=>$user]);

        } catch (\Exception $e) {
            $return['error'] = $e->getMessage();
        }
    }

    public function trackingMyOrder($domain, $orderCode, Request $request){
        $orderService = new orderService();
        try{
            $email = $this->_user->email;

            $result = $orderService->checkTrackingOrderCode($email, $orderCode);
            if(!$result['ok']){
                return view('client.customer.tracking-order', $result);
            }
            else{
                return view('client.customer.detail-tracking-order', $result);
            }

            return view('client.customer.tracking-order');
        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }
    }

    public function myAddress(Request $request){
        $userService = new userService();
        try{
            $user = $userService->getUserByEmail($this->_user->email);

            return view('client.customer.my-address', ['user'=>$user]);

        } catch (\Exception $e) {
            $return['error'] = $e->getMessage();
        }
    }

    public function myAddressDetail($domain, $id, Request $request){
        $userService = new userService();
        $addressService = new addressService();
        try{
            $user = $userService->getUserByEmail($this->_user->email);

            $address = $addressService->getAddressReceiveById($id);
            $data['listCity'] = $addressService->getListCity();
            $data['listDistrict'] = $addressService->getListDistrict();
            $data['user'] = $user;

            if(!$address || $address->user_id != $user->id)
            {
                $data['permission_denied'] = true;
                $data['permission_denied_message'] = 'bạn không có quyền chỉnh sữa địa chỉ này - liên hệ admin : admin@kacana.com';
                return view('client.customer.my-address-detail', $data);
            }

            if($request->isMethod('post')){

                $addressArray = array();
                $addressArray['name'] = $request->get('name', false);
                $addressArray['street'] = $request->get('street', false);
                $addressArray['city_id'] = $request->get('cityId', false);
                $addressArray['district_id'] = $request->get('districtId', false);
                $addressArray['phone'] = $request->get('phone', false);
                $addressArray['id'] = $id;
                if($id){
                    $data['address'] = $addressService->updateAddressReceive($addressArray);
                    $data['ok'] = 1;
                    $data['ok_message'] = 'cập nhật địa chỉ: '.$addressArray['name'].' thành công!';
                }
                else
                {
                    $data['address'] = $addressService->createUserAddress($user->id, $addressArray);
                    $data['ok'] = 1;
                    $data['ok_message'] = 'thêm mới địa chỉ: '.$addressArray['name'].' thành công!';
                }
            }
            elseif($request->isMethod('get'))
                $data['address'] = $address;


            return view('client.customer.my-address-detail', $data);

        } catch (\Exception $e) {
            return view('errors.404', ['error_message' => $e->getMessage()]);
        }
    }

    public function addNewAddressReceive(Request $request){
        $userService = new userService();
        $addressService = new addressService();
        try{
            $user = $userService->getUserByEmail($this->_user->email);

            $data['listCity'] = $addressService->getListCity();
            $data['listDistrict'] = $addressService->getListDistrict();
            $data['user'] = $user;

            if($request->isMethod('post')){

                $addressArray = array();
                $addressArray['name'] = $request->get('name', false);
                $addressArray['street'] = $request->get('street', false);
                $addressArray['city_id'] = $request->get('cityId', false);
                $addressArray['district_id'] = $request->get('districtId', false);
                $addressArray['phone'] = $request->get('phone', false);

                $data['address'] = $addressService->createUserAddress($user->id, $addressArray);
                $data['ok'] = 1;
                $data['ok_message'] = 'thêm mới địa chỉ: '.$addressArray['name'].' thành công!';
                return redirect('/khach-hang/so-dia-chi');
            }

            return view('client.customer.my-address-detail', $data);

        } catch (\Exception $e) {
            return view('errors.404', ['error_message' => $e->getMessage()]);
        }
    }

    public function makeDefaultAddess($domain, $id, Request $request){
        $userService = new userService();
        $addressService = new addressService();

        try{
            $user = $userService->getUserByEmail($this->_user->email);
            $address = $addressService->getAddressReceiveById($id);

            if(!$address || $address->user_id != $user->id || $address->deleted_at)
                return redirect('/khach-hang/so-dia-chi');

            $addressService->makeAddressReceiveDefault($user->id, $id);

            return redirect('/khach-hang/so-dia-chi');


        } catch (\Exception $e) {
            return view('errors.404', ['error_message' => $e->getMessage()]);
        }
    }

    public function deleteMyAddress($domain, $id, Request $request){
        $userService = new userService();
        $addressService = new addressService();

        try{
            $user = $userService->getUserByEmail($this->_user->email);
            $address = $addressService->getAddressReceiveById($id);

            if(!$address || $address->user_id != $user->id || $address->default)
                return redirect('/khach-hang/so-dia-chi');

            $addressService->deleteMyAddress($user->id, $id);

            return redirect('/khach-hang/so-dia-chi');


        } catch (\Exception $e) {
            return view('errors.404', ['error_message' => $e->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @return \BladeView|bool|\Illuminate\View\View
     */
    public function saveProductLike(Request $request){
        $userService = new userService();
        $result['ok'] = 0;
        $userId = $this->_user->id;
        $productId = $request->input('productId');
        $productUrl = $request->input('productUrl');
        try{
            return $userService->saveProductLike($userId, $productId, $productUrl);
        } catch (\Exception $e) {
            if($request->ajax())
            {
                $result['error'] = $e->getMessage();
                return $result;
            }
            else
                return view('errors.404', ['error_message' => $e->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @return \BladeView|bool|\Illuminate\View\View
     */
    public function removeProductLike(Request $request){
        $userService = new userService();
        $result['ok'] = 0;
        $userId = $this->_user->id;
        $productId = $request->input('productId');
        try{
            return $userService->removeProductLike($userId, $productId);
        } catch (\Exception $e) {
            if($request->ajax())
            {
                $result['error'] = $e->getMessage();
                return $result;
            }
            else
                return view('errors.404', ['error_message' => $e->getMessage()]);
        }
    }

    public function productLike(Request $request){
        $userService = new userService();
        try{
            $user = $userService->getUserByEmail($this->_user->email);

            return view('client.customer.my-product-like', ['user'=>$user]);

        } catch (\Exception $e) {
            $return['error'] = $e->getMessage();
        }
    }
}