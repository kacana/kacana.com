<?php namespace App\Http\Controllers\Admin;

use Image;
use Datatables;

class AdvisoryController extends BaseController {

    public function index($domain){
        return view('admin.advisory.index');
    }

    public function getAdvisories(RequestInfoRequest $request){

    }
}
