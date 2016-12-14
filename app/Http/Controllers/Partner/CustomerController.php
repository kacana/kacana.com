<?php namespace App\Http\Controllers\Partner;

use App\services\addressService;
use App\services\commissionService;
use Illuminate\Http\Request;

class CustomerController extends BaseController {


    public function index(Request $request)
    {
        return view('partner.customer.index');
	}

	public function generateCustomerTable(Request $request){
        $params = $request->all();
        $addressService = new addressService();

        try {
            $return = $addressService->generateCustomerTable($params, $this->_user->id);

        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return response()->json($return);
    }

    public function edit($domain, Request $request,$addressId){
        $addressService = new addressService();

        try {
            $address = $addressService->getAddressReceiveById($addressId);

            $cities = $addressService->getListCity()->lists('name', 'id');
            $wards = $addressService->getListWardByDistrictId($address->district_id);
            $districts = $addressService->getListDistrict();

            if($address->user_id != $this->_user->id)
                throw new \Exception('Address is inValid!');

            if($request->isMethod('PUT')){
                $addressService->updateAddressReceive($request->all());
            }

            return view('partner.customer.edit', ['user_address' => $address, 'cities' => $cities, 'districts' => $districts, 'wards' => $wards]);

        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }
    }

    public function generateAllCommissionByUserTable($domain, Request $request, $addressReceiveId){
        $params = $request->all();

        $commissionService = new commissionService();

        try {
            $return = $commissionService->generateAllCommissionByUserTable($params, $this->_user->id, $addressReceiveId);

        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return response()->json($return);
    }
}
