<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Auth;
use App\services\authService;

/**
 * Class AuthController
 * @package App\Http\Controllers\Auth
 */
class AuthController extends Controller
{
    use AuthenticatesAndRegistersUsers;

    // Rest of AuthController class...

    /**
     * @param Request $request
     * @return \BladeView|bool|\Illuminate\View\View
     */
    public function getLogin(Request $request)
    {
        if(Auth::check())
            return redirect()->intended('/');
        else
            return view('auth.login');
    }

    /**
     * @param Request $request
     * @return \BladeView|bool|\Illuminate\Http\RedirectResponse|\Illuminate\View\View|\Symfony\Component\HttpFoundation\Response
     */
    public function authLogin(Request $request)
    {
        $authService = new authService();

        $host = explode('.', $request->getHttpHost());
        $role = $host[0];
        $email = $request->input('email', false);
        $password = $request->input('password', false);
        $postAjax = $request->ajax();

        try{
            $results = $authService->login($email, $password, $role);

            if(!$postAjax)
            {
                if($results['ok'])
                    return redirect()->intended('/');
                else
                    return view('auth.login',$results);
            }
            else
                return response()->json($results);


        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return view('auth.login');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getLogout(Request $request){
        Auth::logout();
        return redirect()->to('/');
    }
}