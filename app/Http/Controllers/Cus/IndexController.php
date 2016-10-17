<?php namespace App\Http\Controllers\Cus;

use App\services\orderService;
class IndexController extends BaseController {

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
        $orderService = new orderService();

        $totalOrder = $orderService->getTotalOrderCurrentUser();
        $totalOrderFinish = $orderService->getTotalOrderCurrentUser(12);

		return view('cus.index.index', array('total_order' => $totalOrder));
	}

}
