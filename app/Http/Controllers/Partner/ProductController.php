<?php namespace App\Http\Controllers\Partner;

use App\services\productService;
use App\services\tagService;
use App\services\trackingService;
use App\services\userService;
use Illuminate\Http\Request;
use App\services\orderService;
use Kacana\Util;
use Auth;

/**
 * Class SocialController
 * @package App\Http\Controllers\Partner
 */
class ProductController extends BaseController {

    public function index(Request $request)
    {
        return view('partner.product.index');
    }
}
