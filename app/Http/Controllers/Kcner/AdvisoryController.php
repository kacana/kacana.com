<?php namespace App\Http\Controllers\Kcner;

use Image;
use Datatables;

class AdvisoryController extends BaseController {

    public function index($domain){
        return view('kcner.advisory.index');
    }

    public function getAdvisories(RequestInfoRequest $request){

    }
}
