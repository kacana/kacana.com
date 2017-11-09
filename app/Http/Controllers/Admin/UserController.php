<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use App\Http\Requests\addressReceiveModelRequest;
use App\models\UserAddress;
use App\models\UserType;
use App\models\addressReceiveModel;
use App\services\addressService;
use App\services\userTrackingService;
use App\services\orderService;
use GuzzleHttp\Psr7\Response;
use Image;
use Datatables;
use App\models\User;
use Form;
use App\models\addressCityModel;
use App\models\addressWardModel;
use App\services\userService;
use Illuminate\Http\Request;
use Hash;

class UserController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('admin.user.index');
	}

    public function generateUserTable(Request $request)
    {
        $params = $request->all();
        $userService = new userService();

        try {
            $return = $userService->generateUserTable($params);

        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return response()->json($return);
    }

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($domain, $id, UserRequest $request)
	{
	    $userService = new userService();

        if($request->isMethod('POST'))
        {
            $name = $request->input('name');
            $email = $request->input('email');
            $phone = $request->input('phone');
            $role = $request->input('role');
            $password = $request->input('password');

            $dataUser = [
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'role' => $role
            ];

            if($password){
                $password = Hash::make(md5($password));

                array_add($dataUser, 'password', $password);
            }

            $userService->updateItem($id, $dataUser);
        }

        $user = $userService->getUserById($id);

        return view('admin.user.edit',array('item' =>$user));
	}

    public function showCreateForm()
    {
        $types = UserType::lists('name', 'id');
        return view("admin.user.form-create", array('types' => $types));
    }

    /*
     * - function mame: setStatus
     */
    public function setStatus($domain, $id, $status)
    {
        $str = '';
        $user = new User;
        if($user->updateItem($id, (array('status'=>$status)))){
            if($status == 0){
                $str = "Đã chuyển sang trạng thái inactive thành công!";
            }else{
                $str = "Đã chuyển sang trạng thái active thành công!";
            }
        }
        return $str;
    }

    /*
     * - function mame: showFormEditUserAddress
     */
    public function showFormEditUserAddress($domain, $id)
    {
        $address = addressReceiveModel::find($id);
        $cities = addressCityModel::lists('name','id');
        $ward = new addressWardModel();

        if(empty($address->city_id)){
            $city_id = CITY_ID_DEFAULT;
        }else{
            $city_id = $address->city_id;
        }
        $wards = $ward->getItemsByCityId($city_id)->lists('name', 'id');

        return view("admin.user.form-edit-address", array('item'=>$address, 'cities' =>$cities, 'wards'=>$wards));
    }

    /*
    * - function mame: editUserAddress
    */
    public function editUserAddress(addressReceiveModelRequest $request)
    {
        $id = $request->get('id');
        $address = addressReceiveModel::find($id);
        $result = $address->updateItem($id, $request->all());
        echo json_encode($result);
    }

    /*
    * - function mame: showWardSelect
    */
    public function showListWards($domain, $id)
    {
        $ward = new addressWardModel;
        $lists = $ward->getItemsByCityId($id)->lists('name', 'id');
        echo Form::select('ward_id', $lists,null, array('class'=>'form-control'));
    }

    public function generateAddressReceiveByUserId($domain, $userId, Request $request){

        $addressService = new addressService();
        $params = $request->all();

        try {
            $return = $addressService->generateAddressReceiveByUserId($params, $userId);

        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return response()->json($return);
    }

    public function generateAllOrderDetailByUserTable($domain, Request $request, $userId){
        $params = $request->all();

        $orderService = new orderService();

        try {
            $return = $orderService->generateAllOrderDetailByUserTable($params, $userId);

        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return response()->json($return);
    }

    public function getTrackingMessageInfo(Request $request){
        $idTracking = $request->input('idTracking', 0);

        $userTrackingService = new userTrackingService();
        $return['ok'] = 0;

        try {

            $return['data'] = $userTrackingService->getTrackingHistoryInformation($idTracking);
            $return['ok'] = 1;
        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return response()->json($return);
    }

    public function detailUserTracking(Request $request){
        $idTracking = $request->input('idTracking', 0);
        $userTrackingService = new userTrackingService();
        $userTracking = $userTrackingService->getUserTracking($idTracking);
        return view("admin.user.user-tracking", array('userTracking'=>$userTracking));

    }

    public function generateUserTrackingHistoryTable(Request $request)
    {
        $params = $request->all();
        $userTrackingService = new userTrackingService();
        $trackingId = $request->input('trackingId', 0);
        try {
            $return = $userTrackingService->generateUserTrackingHistoryTable($params, $trackingId);

        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return response()->json($return);
    }

    public function facebookComment(Request $request){
        return view('admin.user.facebook-comment');
    }

    public function generateFacebookCommentTable(Request $request)
    {
        $params = $request->all();
        $userService = new userService();

        try {
            $return = $userService->generateFacebookCommentTable($params);

        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return response()->json($return);
    }

}
