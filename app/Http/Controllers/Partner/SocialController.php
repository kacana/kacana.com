<?php namespace App\Http\Controllers\Partner;

use App\services\productService;
use App\services\tagService;
use App\services\trackingService;
use App\services\userService;
use Illuminate\Http\Request;
use App\services\orderService;
use Kacana\Util;
use Auth;

/**
 * Class SocialController
 * @package App\Http\Controllers\Partner
 */
class SocialController extends BaseController {


    /**
     * @param Request $request
     * @return \BladeView|bool|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $userService = new userService();
        $user = Auth::user();
        $facebookAccountBusiness = $userService->getUserAccountBusinessSocial($user->id, KACANA_SOCIAL_TYPE_FACEBOOK);
        return view('partner.social.index', ['facebookAccountBusiness' => $facebookAccountBusiness]);
	}

    /**
     * @param Request $request
     * @return \BladeView|bool|\Illuminate\View\View|mixed|\Symfony\Component\HttpFoundation\Response
     */
    public function addFacebookAccount(Request $request){
        $util = new Util();
        $userService = new userService();
        $accessToken = $request->input('accessToken', '');
        $result['ok'] = 0;
        $result['accessToken'] = $accessToken;

        try {
            $user = Auth::user();

            $facebook = $util->initFacebook();

            // OAuth 2.0 client handler
            $oAuth2Client = $facebook->getOAuth2Client();

            // Exchanges a short-lived access token for a long-lived one
            $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
            $facebook->setDefaultAccessToken($longLivedAccessToken);

            $profile = $facebook->getProfile();

            $result = $userService->createBusinessSocialAccount($profile, $longLivedAccessToken, $user);

        } catch(\Facebook\Exceptions\FacebookResponseException $e) {
            if($request->ajax())
            {
                $result['error_message'] = $e->getMessage();
                return $result;
            }
            else
                return view('errors.404', ['error_message' => $e->getMessage()]);
        }

        return response()->json($result);
    }

    /**
     * @param Request $request
     * @return \BladeView|bool|\Illuminate\View\View|\Symfony\Component\HttpFoundation\Response
     */
    public function changeNameSocialItem(Request $request){
        $userService = new userService();

        $name = $request->input('name', '');
        $type = $request->input('type', 0);
        $socialId = $request->input('socialId', 0);
        $result['ok'] = 0;
        try{
            $result['data'] = $userService->updateNameBusinessSocialAccount($name, $socialId, $type, $this->_user->id);
            $result['ok'] = 1;
        } catch(\Facebook\Exceptions\FacebookResponseException $e) {
            if($request->ajax())
            {
                $result['error_message'] = $e->getMessage();
                return $result;
            }
            else
                return view('errors.404', ['error_message' => $e->getMessage()]);
        }

        return response()->json($result);
    }

    /**
     * @param Request $request
     * @return \BladeView|bool|\Illuminate\View\View|\Symfony\Component\HttpFoundation\Response
     */
    public function deleteSocialItem(Request $request)
    {
        $userService = new userService();

        $type = $request->input('type', 0);
        $socialId = $request->input('socialId', 0);
        $result['ok'] = 0;

        try{
            $result['data'] = $userService->deleteBusinessSocialAccount($socialId, $type, $this->_user->id);
            $result['ok'] = 1;
        } catch(\Facebook\Exceptions\FacebookResponseException $e) {
            if($request->ajax())
            {
                $result['error_message'] = $e->getMessage();
                return $result;
            }
            else
                return view('errors.404', ['error_message' => $e->getMessage()]);
        }

        return response()->json($result);
    }
}
