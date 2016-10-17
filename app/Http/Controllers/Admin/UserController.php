<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use App\Http\Requests\addressReceiveModelRequest;
use App\models\UserAddress;
use App\models\UserType;
use App\models\addressReceiveModel;
use GuzzleHttp\Psr7\Response;
use Image;
use Datatables;
use App\models\User;
use Form;
use App\models\addressCityModel;
use App\models\addressWardModel;
use App\services\userService;
use Illuminate\Http\Request;

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
        $user = User::find($id);
        $types = UserType::lists('name', 'id');
        if($request->all()){
            $user->updateItem($id, $request->all());
            $user = User::find($id);
        }
        return view('admin.user.edit',array('item' =>$user, 'types' =>$types));
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
     * - function mame: getUserAddress
     * list all user address on user detail page with table format
     * @params: uid - id of user
     */
    public function getUserAddress($domain, $id)
    {
        $user_address = new UserAddress;
        $list_address = $user_address->getUserAddress($id);

        return Datatables::of($list_address)
            ->edit_column('name', function($row){
                return $row->addressReceive->name;
            })
            ->edit_column('email', function($row){
                return $row->addressReceive->email;
            })
            ->edit_column('phone', function($row){
                return $row->addressReceive->phone;
            })
            ->edit_column('street', function($row){
                return $row->addressReceive->street;
            })
            ->edit_column('city', function($row){
                return addressCityModel::showName($row->addressReceive->city_id);
            })
            ->edit_column('ward', function($row){
                return addressWardModel::showName($row->addressReceive->ward_id);
            })
            ->add_column('action', function ($row) {
                return showActionButton('Kacana.user.userAddress.showFormEdit('.$row->id.')', '', true);
            })
            ->make(true);
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



}
