<?php namespace App\Http\Controllers;

class IndexController extends BaseController {

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('index.index');
	}

}
