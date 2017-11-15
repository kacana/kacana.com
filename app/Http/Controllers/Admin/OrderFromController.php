<?php namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\services\orderFromService;

class OrderFromController extends BaseController {

    public function index()
    {
        return view('admin.orderfrom.index');
    }

    public function generateOrderFromTable(Request $request){
        $params = $request->all();
        $orderFromService = new orderFromService();

        try {
            $return = $orderFromService->generateOrderFromTable($params);

        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }
        return response()->json($return);
    }

    /**
     * Tag Controller create order from Action
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createOrderFrom(Request $request)
    {
        $orderFromService = new orderFromService();

        $orderFromName = $request->input('name', '');
        $orderFromDesc = $request->input('description', '');
        $userId = $this->_user->id;
        $return['ok'] = 0;

        try{
            if($orderFromName)
            {
                $return['ok'] = 1;
                $orderFrom = $orderFromService->createOrderFrom($orderFromName, $orderFromDesc, $userId);
                return redirect('/orderFrom');
            }
        }
        catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return response()->json($return);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editOrderFrom($id, Request $request){
        $orderFromService = new orderFromService();
        $orderFromId = $request->input('id');
        $orderFromName = $request->input('name');
        $orderFromDescription = $request->input('description');

        $return['ok'] = 0;

        try{
            if($orderFromName)
            {
                $return['ok'] = 1;
                $return['data'] = $orderFromService->updateOrderFrom($orderFromId, $orderFromName, $orderFromDescription);
                return redirect('/orderFrom');
            }
        }
        catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return response()->json($return);
    }

}
