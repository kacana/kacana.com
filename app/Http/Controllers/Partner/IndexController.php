<?php namespace App\Http\Controllers\Partner;

use Illuminate\Http\Request;

class IndexController extends BaseController {


    public function index(Request $request)
    {
        return view('partner.index.index');
	}
}
