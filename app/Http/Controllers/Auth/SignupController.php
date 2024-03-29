<?php
namespace App\Http\Controllers\Auth;

use App\services\authService;
use App\services\mailService;
use App\services\userService;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Auth;
use Kacana\Util;

/**
 * Class SignupController
 * @package App\Http\Controllers\Auth
 */
class SignupController extends Controller
{

    /**
     * @param Request $request
     * @return \BladeView|bool|\Illuminate\Http\RedirectResponse|\Illuminate\View\View|\Symfony\Component\HttpFoundation\Response
     */
    public function signup(Request $request)
    {
        $authService = new authService();
        $emailService = new mailService();
        $name = $request->input('name', '');
        $email = $request->input('email', '');
        $phone = $request->input('phone', '');
        $password = $request->input('password', '');
        $confirmPassword = $request->input('confirmPassword', '');
        $postAjax = $request->ajax();

        $host = explode('.', $request->getHttpHost());
        $roleLink = $host[0];

        try{
            if($request->isMethod('post'))
            {
                $results = $authService->signup($name, $email, $phone, $password, $confirmPassword);

                if($results['ok'])
                {
                    $user = $results['data'];
                    if($roleLink != KACANA_AUTH_ADMIN_NAME)
                        \Auth::loginUsingId($user->id, true);
                    $emailService->sendEmailNewUser($email);
                }


                if($postAjax)
                    return response()->json($results);
                else{
                    if($results['ok']) {
                        return redirect()->intended('/');
                    }
                    else
                        return view('auth.signup', $results);
                }
            }
        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }
        return view('auth.signup');

    }


    /**
     * @param Request $request
     * @return \BladeView|bool|\Illuminate\View\View
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    public function socialLoginCallback(Request $request){
        $util = new Util();
        $userService = new userService();
        $accessToken = $request->input('accessToken', '');
        $type = $request->input('type', '');
        $result['ok'] = 0;
        $result['accessToken'] = $accessToken;
        $result['type'] = $type;
        try {

            if($type == KACANA_SOCIAL_TYPE_FACEBOOK)
            {
                $email = $request->input('email', false);
                $facebook = $util->initFacebook();

                // OAuth 2.0 client handler
                $oAuth2Client = $facebook->getOAuth2Client();

                // Exchanges a short-lived access token for a long-lived one
                $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);

                $facebook->setDefaultAccessToken($longLivedAccessToken);

                $profile = $facebook->getProfile();

//                print_r($facebook->addTestUser($accessToken, $profile['id'], $profile['name']));die;

                if(!isset($profile['email']) && $email)
                {
                    $profile['email'] = $email;
                    $user = $userService->getUserByEmail($profile['email']);
                    if($user)
                    {
                        $result['error_code'] = KACANA_AUTH_SIGNUP_ERROR_EMAIL_EXISTS;
                        return response()->json($result);
                    }
                }

                $result = $userService->createUserFromFacebookProfile($profile, $longLivedAccessToken);
            }
            elseif($type == KACANA_SOCIAL_TYPE_GOOGLE){
                $google = $util->initGoogle();
                $client = $google->getGoogleClient();
                $client->authenticate($accessToken);
                $token_data = json_decode($client->getAccessToken());
                $google_oauth = $google->getGoogleServiceOauth2();
                $profile = $google_oauth->userinfo->get();
                $result = $userService->createUserFromGoogleProfile($profile, $token_data->access_token);
            }


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

    public function facebookCallbackAllowPost(Request $request){
        $util = new Util();
        $userService = new userService();
        $accessToken = $request->input('accessToken', '');
        $result['ok'] = 0;
        $result['accessToken'] = $accessToken;
        try {
            if(Auth::check())
            {
                $user = Auth::user();
                $facebook = $util->initFacebook();

                // OAuth 2.0 client handler
                $oAuth2Client = $facebook->getOAuth2Client();

                // Exchanges a short-lived access token for a long-lived one
                $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);

                $facebook->setDefaultAccessToken($longLivedAccessToken);

                $profile = $facebook->getProfile();

                $result = $userService->updateFacebookAccessToken($profile, $longLivedAccessToken, $user);
            }
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