<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

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

}
