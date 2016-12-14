<?php namespace App\Http\Controllers\Partner;

use App\services\commissionService;
use App\services\orderService;
use Illuminate\Http\Request;

class CommissionController extends BaseController {


    public function index(Request $request)
    {
        $commissionService = new commissionService();
        $commissions = $commissionService->informationCommission($this->_user->id);

        return view('partner.commission.index', ['commissions' => $commissions]);
    }

    public function generateAllCommissionTable(Request $request){
        $params = $request->all();
        $commissionService = new commissionService();

        try {
            $return = $commissionService->generateAllCommissionTable($params, $this->_user->id);

        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return response()->json($return);
    }

    public function generateTempCommissionTable(Request $request){
        $params = $request->all();
        $commissionService = new commissionService();

        try {
            $return = $commissionService->generateTempCommissionTable($params, $this->_user->id);

        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return response()->json($return);
    }

    public function generateValidCommissionTable(Request $request){
        $params = $request->all();
        $commissionService = new commissionService();

        try {
            $return = $commissionService->generateValidCommissionTable($params, $this->_user->id);

        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return response()->json($return);
    }

    public function generatePaymentCommissionTable(Request $request){
        $params = $request->all();
        $commissionService = new commissionService();

        try {
            $return = $commissionService->generatePaymentCommissionTable($params, $this->_user->id);

        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return response()->json($return);
    }

    public function generatePaymentHistoryTable(Request $request){
        $params = $request->all();
        $commissionService = new commissionService();

        try {
            $return = $commissionService->generatePaymentHistoryTable($params, $this->_user->id);

        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return response()->json($return);
    }

    public function detailTransfer($domain, Request $request, $id){

        $commissionService = new commissionService();

        try {
            $payment = $commissionService->getPartnerPayment($id);

        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return view('partner.commission.detail-transfer', ['payment'=>$payment]);
    }
}
