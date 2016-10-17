<?php namespace App\Http\Controllers\Admin;

class IndexController extends BaseController {

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('admin.index.index');
	}

}
