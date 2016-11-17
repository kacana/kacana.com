<?php namespace App\Http\Controllers\Partner;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;
use \Kacana\Util;

class BaseController extends Controller {

	public $_user = false;

	public function __construct()
	{
        $Util = new Util();
        $this->_user = $Util->getCurrentUser();
        View::share('user', $Util::getCurrentUser());
	}
}
