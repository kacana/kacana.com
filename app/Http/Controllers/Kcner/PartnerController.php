<?php namespace App\Http\Controllers\Kcner;

use App\services\addressService;
use App\services\commissionService;
use App\services\productService;
use App\services\shipGhnService;
use App\services\userService;
use Illuminate\Http\Request;
use App\services\orderService;

class PartnerController extends BaseController {

    public function index($domain){
        return view('kcner.partner.index');
    }

    public function generateUserWaitingTransferTable(Request $request){
        $params = $request->all();
        $userService = new userService();

        try {
            $return = $userService->generateUserWaitingTransferTable($params);

        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return response()->json($return);
    }

    public function detail($domain, Request $request, $userId)
    {
        $commissionService = new commissionService();
        $userService = new userService();

        $commissions = $commissionService->informationCommission($userId);
        $user = $userService->getUserById($userId);

        return view('kcner.partner.detail', ['commissions' => $commissions, 'user' => $user]);
    }

    public function generateAllCommissionTable($domain, Request $request, $userId){
        $params = $request->all();
        $commissionService = new commissionService();

        try {
            $return = $commissionService->generateAllCommissionTable($params, $userId);

        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return response()->json($return);
    }

    public function generateTempCommissionTable($domain, Request $request, $userId){
        $params = $request->all();
        $commissionService = new commissionService();

        try {
            $return = $commissionService->generateTempCommissionTable($params, $userId);

        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return response()->json($return);
    }

    public function generateValidCommissionTable($domain, Request $request, $userId){
        $params = $request->all();
        $commissionService = new commissionService();

        try {
            $return = $commissionService->generateValidCommissionTable($params, $userId);

        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return response()->json($return);
    }

    public function generatePaymentCommissionTable($domain, Request $request, $userId){
        $params = $request->all();
        $commissionService = new commissionService();

        try {
            $return = $commissionService->generatePaymentCommissionTable($params, $userId);

        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return response()->json($return);
    }

    public function generatePaymentHistoryTable($domain, Request $request, $userId){
        $params = $request->all();
        $commissionService = new commissionService();

        try {
            $return = $commissionService->generatePaymentHistoryTable($params, $userId);

        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return response()->json($return);
    }

    public function transfer(Request $request){
        $commissionService = new commissionService();

        $orderDetailIds = $request->input('orderDetailId', 0);
        $userId = $request->input('userId', 0);
        $ref = $request->input('ref', 0);
        $note = $request->input('note', 0);

        try {
            $commissionService->transferPayment($orderDetailIds, $userId, $ref, $note);

        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return redirect('/partner/detail/'.$userId);
    }

    public function historyTransfer(Request $request){
        return view('kcner.partner.history-transfer');
    }

    public function generatePartnerPaymentTable(Request $request){
        $params = $request->all();
        $commissionService = new commissionService();

        try {
            $return = $commissionService->generatePartnerPaymentTable($params);

        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return response()->json($return);
    }

    public function detailTransfer($domain, Request $request, $id){
        $params = $request->all();
        $commissionService = new commissionService();

        try {
            $payment = $commissionService->getPartnerPayment($id);

        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return view('kcner.partner.detail-transfer', ['payment'=>$payment]);
    }
}
