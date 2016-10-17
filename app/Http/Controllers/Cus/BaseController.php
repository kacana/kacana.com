<?php namespace App\Http\Controllers\Cus;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;
use \Kacana\Util;
use Auth;

class BaseController extends Controller {

	/**
	 * run first
	 *
	 * @return void
	 */
	public function __construct()
	{
        $Util = new Util();
        View::share('user', $Util::getCurrentUser());
	}
}
