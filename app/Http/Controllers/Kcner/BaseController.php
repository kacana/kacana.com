<?php namespace App\Http\Controllers\Kcner;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;
use \Kacana\Util;
use Illuminate\Http\Request;
use App\services\baseService;

/**
 * Class BaseController
 * @package App\Http\Controllers\Kcner
 */
class BaseController extends Controller {

	public $_user = false;

	/**
	 * BaseController constructor.
     */
	public function __construct()
	{
        $Util = new Util();
		$this->_user = $Util->getCurrentUser();
		View::share('user', $Util::getCurrentUser());
	}

	/**
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\Response
     */
	public function changeStatus(Request $request){
		$id = $request->input('id');
		$value = $request->input('value');
		$tableName = $request->input('tableName');
		$field = $request->input('field');

		$baseService = new baseService();
		$return['ok'] = 0;
		try{
			$return['ok'] = 1;
			$return['data'] = $baseService->changefieldDropdown($id, $value, $field, $tableName);

		} catch (\Exception $e) {
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
    public function updateField(Request $request){
        $id = $request->input('id');
        $content = $request->input('content');
        $tableName = $request->input('table');
        $field = $request->input('field');

        $baseService = new baseService();
        $return['ok'] = 0;
        try{
            $return['ok'] = 1;
            $return['data'] = $baseService->updateField($id, $content, $field, $tableName);

        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return response()->json($return);
    }
}
