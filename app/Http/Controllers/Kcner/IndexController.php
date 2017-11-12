<?php namespace App\Http\Controllers\Kcner;

use App\services\orderService;
use App\services\productService;
use App\services\shipGhnService;
use App\services\shipGhtkService;
use App\services\trackingService;
use App\services\userService;
use App\services\userTrackingService;
use Illuminate\Http\Request;

/**
 * Class IndexController
 * @package App\Http\Controllers\Kcner
 */
class IndexController extends BaseController {


    /**
     * @param Request $request
     * @return \BladeView|bool|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('kcner.index.index');
	}
}
