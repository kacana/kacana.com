<?php namespace App\Http\Middleware;

use App\Http\Requests\Request;
use App\models\userTrackingHistory;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use App\services\userTrackingService;

class Client {

	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	protected $client;

	/**
	 * Create a new filter instance.
	 *
	 * @param  Guard  $client
	 * @return void
	 */
	public function __construct(Guard $client)
	{
		$this->client = $client;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
        $this->trackingUser($request);

		$env = \App::environment();
		$pass = $request->input('pass-wait-to-release', false);

		if($pass)
		{
			\Session::set('pass-wait-to-release', $pass);
		}
		else
		{
			$pass = \Session::get('pass-wait-to-release');
		}


		if(KACANA_WAIT_TO_RELEASE && !($env == KACANA_ENVIRONMENT_DEVELOPMENT) && $pass != KACANA_PASS_WAIT_TO_RELEASE)
		{
			if ($request->ajax())
			{
				return response('Unauthorized.', 401);
			}
			else {
				return view('client.coming.index');
			}
		}

		return $next($request);
	}

	public function trackingUser($request){
        $userTrackingService = new userTrackingService();

	    $userTrackingSessionId = \Session::get(KACANA_USER_TRACKING_SESSION);

        $referer = $request->headers->get('referer');
        $userAgent = $request->headers->get('user-agent');
        $url = \Request::fullUrl();
        $ip = \Request::ip();
        $dataTracking = ['ip'=>$ip, 'url'=>$url, 'referer'=>$referer, 'user_agent'=>$userAgent];

        // check user agent is real user - ignore auto boot search service
        if(!(strpos($userAgent, 'Bot') || strpos($userAgent, 'bot') || strpos($userAgent, 'facebookexternalhit')))
        {
            if(!$userTrackingSessionId)
            {
                $sessionCode = \Session::getId();
                $dataTracking['code'] = $sessionCode;
                $userTracking = $userTrackingService->createUserTracking($dataTracking);
                \Session::set(KACANA_USER_TRACKING_SESSION, $userTracking->id);
                $userTrackingSessionId = $userTracking->id;
            }
            unset($dataTracking['code']);
            $dataTracking['type_call'] = 'normal';

            if($request->ajax())
                $dataTracking['type_call'] = 'ajax';

            $dataTracking['session_id'] = $userTrackingSessionId;
            $userTrackingHistory = $userTrackingService->createUserTrackingHistory($dataTracking);
            \Session::set(KACANA_USER_TRACKING_HISTORY_ID, $userTrackingHistory->id);
        }
    }

}
