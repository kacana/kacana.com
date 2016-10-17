<?php namespace App\Http\Controllers\Client;

use Httpful\Request;

class ContactController extends BaseController {

    public function index(Request $request){

    }

    public function introduction(){
        return view('client.contact.index', array('page' =>'intro'));
    }

    public function contactInformation(){
        return view('client.contact.index', array('page' =>'contact-information'));
    }

    public function returnRule(){
        return view('client.contact.index', array('page' =>'return-rule'));
    }

    public function privacyRule(){
        return view('client.contact.index', array('page' =>'privacy-rule'));
    }

    public function customerRule(){
        return view('client.contact.index', array('page' =>'customer-rule'));
    }

    public function saleWithUs(){
        return view('client.contact.index', array('page' =>'sale-with-us'));
    }
}