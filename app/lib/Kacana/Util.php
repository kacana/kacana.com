<?php namespace Kacana;
use Illuminate\Support\Facades\Auth;
use Kacana\Client\Facebook;
use Kacana\Client\Google;
class Util {
    public static function getCurrentUser(){
        return Auth::user();
    }
    public static function updateUserInformation(){

    }
    public static function isLoggedIn(){
        return Auth::check();
    }

    public static function isDevEnvironment(){
        $env = \App::environment();
        return ($env == KACANA_ENVIRONMENT_DEVELOPMENT);
    }

    public function initFacebook(){
        $fb = new Facebook();
        return $fb;
    }

    public function initGoogle(){
        $googleClient = new Google();
        return $googleClient;
    }

}