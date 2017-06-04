<?php namespace App\Http\Controllers\Admin;

use App\services\orderService;
use App\services\productService;
use App\services\trackingService;
use App\services\userService;
use App\services\userTrackingService;
use Illuminate\Http\Request;

/**
 * Class IndexController
 * @package App\Http\Controllers\Admin
 */
class IndexController extends BaseController {


    /**
     * @param Request $request
     * @return \BladeView|bool|\Illuminate\View\View
     */
    public function index(Request $request)
	{
	    $duration = $request->input('duration', KACANA_REPORT_DURATION_DEFAULT);
	    $userService = new userService();
        $orderService = new orderService();
        $productService = new productService();
        $trackingService = new trackingService();
        $userTrackingService = new userTrackingService();

        $data = array();
        try{
            $data['duration'] = $duration;

            $data['user_count_duration'] = $userService->getCountUser($duration);
            $data['user_count'] = $userService->getCountUser();

            $data['order_count_duration'] = $orderService->getCountOrder($duration);
            $data['order_count'] = $orderService->getCountOrder();

            $data['like_count_duration'] = $userService->getCountLike($duration);
            $data['like_count'] = $userService->getCountLike();

            $data['view_count_duration'] = $productService->getCountProductView($duration);
            $data['view_count'] = $productService->getCountProductView();

            $data['search_count_duration'] = $trackingService->getCountTrackingSearch($duration);
            $data['search_count'] = $trackingService->getCountTrackingSearch();

            $data['user_session_duration'] = $userTrackingService->getCountTracking(1);
            $data['user_session'] = $userTrackingService->getCountTracking();

            return view('admin.index.index', $data);
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

	public function reportChartUser(Request $request){
        $dateRange = $request->input('dateRange', false);
        $type = $request->input('type', 'day');
        $userService = new userService();
        $return = array();
        $return['ok'] = 0;
        try{
            $return['data'] = $userService->getUserReport($dateRange, $type);
            $return['ok'] = 1;
        } catch (\Exception $e) {
            if($request->ajax())
            {
                $return['error'] = $e->getMessage();
            }
            else
                return view('errors.404', ['error_message' => $e->getMessage()]);
        }

        return response()->json($return);
    }

    public function reportChartOrder(Request $request){
        $dateRange = $request->input('dateRange', false);
        $type = $request->input('type', 'day');

        $orderService = new orderService();
        $return = array();
        $return['ok'] = 0;
        try{
            $return['data'] = $orderService->getOrderReport($dateRange, $type);
            $return['ok'] = 1;
        } catch (\Exception $e) {
            if($request->ajax())
            {
                $return['error'] = $e->getMessage();
            }
            else
                return view('errors.404', ['error_message' => $e->getMessage()]);
        }

        return response()->json($return);
    }

    public function reportChartProductLike(Request $request){
        $dateRange = $request->input('dateRange', false);
        $type = $request->input('type', 'day');

        $userService = new userService();
        $return = array();
        $return['ok'] = 0;
        try{
            $return['data'] = $userService->getUserProductLikeReport($dateRange, $type);
            $return['ok'] = 1;
        } catch (\Exception $e) {
            if($request->ajax())
            {
                $return['error'] = $e->getMessage();
            }
            else
                return view('errors.404', ['error_message' => $e->getMessage()]);
        }

        return response()->json($return);
    }

    public function reportChartProductView(Request $request){
        $dateRange = $request->input('dateRange', false);
        $type = $request->input('type', 'day');

        $productService = new productService();
        $return = array();
        $return['ok'] = 0;
        try{
            $return['data'] = $productService->getProductViewReport($dateRange, $type);
            $return['ok'] = 1;
        } catch (\Exception $e) {
            if($request->ajax())
            {
                $return['error'] = $e->getMessage();
            }
            else
                return view('errors.404', ['error_message' => $e->getMessage()]);
        }

        return response()->json($return);
    }

    public function reportChartTrackingSearch(Request $request){
        $trackingService = new trackingService();

        $dateRange = $request->input('dateRange', false);
        $type = $request->input('type', 'day');

        $return = array();
        $return['ok'] = 0;
        try{
            $return['data'] = $trackingService->getTrackingSearchReport($dateRange, $type);
            $return['ok'] = 1;
        } catch (\Exception $e) {
            if($request->ajax())
            {
                $return['error'] = $e->getMessage();
            }
            else
                return view('errors.404', ['error_message' => $e->getMessage()]);
        }

        return response()->json($return);
    }

    public function reportDetailTableUser(Request $request)
    {
        $params = $request->all();
        $userService = new userService();
        try {
            $return = $userService->reportDetailTableUser($params);

        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return response()->json($return);
    }

    public function reportDetailTableOrder(Request $request)
    {
        $params = $request->all();
        $orderService = new orderService();

        try {
            $return = $orderService->reportDetailTableOrder($params);

        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return response()->json($return);
    }

    public function reportDetailTableProductLike(Request $request)
    {
        $params = $request->all();
        $productService = new productService();

        try {
            $return = $productService->reportDetailTableProductLike($params);

        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return response()->json($return);
    }

    public function reportDetailTableProductView(Request $request)
    {
        $params = $request->all();
        $productService = new productService();
        try {
            $return = $productService->reportDetailTableProductView($params);

        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return response()->json($return);
    }

    public function reportDetailTableTrackingSearch(Request $request)
    {
        $params = $request->all();
        $trackingService = new trackingService();

        try {
            $return = $trackingService->reportDetailTableTrackingSearch($params);

        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return response()->json($return);
    }

    public function reportChartUserTracking(Request $request)
    {
        $userTrackingService = new userTrackingService();

        $dateRange = $request->input('dateRange', false);
        $type = $request->input('type', 'day');

        $return = array();
        $return['ok'] = 0;

        try {
            $return['data'] = $userTrackingService->reportChartUserTracking($dateRange, $type);
            $return['ok'] = 1;

        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return response()->json($return);
    }

    public function reportDetailTableUserTracking(Request $request)
    {
        $params = $request->all();
        $userTrackingService = new userTrackingService();

        try {
            $return = $userTrackingService->reportDetailTableUserTracking($params);

        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return response()->json($return);
    }
}
