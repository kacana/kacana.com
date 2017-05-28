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

    public function buyGuide(){
        return view('client.contact.index', array('page' =>'buy-guide'));
    }

    public function companyRule(){
        return view('client.contact.index', array('page' =>'company-rule'));
    }

    public function paymentRule(){
        return view('client.contact.index', array('page' =>'payment-rule'));
    }

    public function shippingRule(){
        return view('client.contact.index', array('page' =>'shipping-rule'));
    }

    public function contactUs(){
        return view('client.contact.index', array('page' =>'contact-us'));
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

    public function getMoneyWithUs(){
        return view('client.contact.index', array('page' =>'get-money-with-us'));
    }
}