<?php namespace Kacana;

use App\models\storeModel;
use App\services\userService;
use Auth;
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

    public function getStores(){
        $storeModel = new storeModel();
        return $storeModel->getAll();
    }

    public static function hasSocial($type = KACANA_SOCIAL_TYPE_FACEBOOK)
    {
        $userService = new userService();
        $user = Auth::user();

        if(Auth::check())
        {
            $user = $userService->getUserByEmail($user->email);
            foreach ($user->userSocial as $userSocial)
            {
                if($userSocial->type == $type && $type != KACANA_SOCIAL_TYPE_FACEBOOK)
                {
                    return true;
                }
                elseif($userSocial->type == $type && $type == KACANA_SOCIAL_TYPE_FACEBOOK && $userSocial->ref == 1)
                {
                    return true;
                }
            }
        }
        return false;
    }

}