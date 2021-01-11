<?php

namespace App\Http\Middleware;

use Closure;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class AuthSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
		//$user = Socialite::driver('google')->stateless()->user();
		$user = $request->session()->get('user');
		//dd($user);
		if($user){
			$client = new Client([
				'base_uri' => '',
			]);
	
			$lin = 'https://oauth2.googleapis.com/tokeninfo?id_token=' . $user->token;
	
			$response = $client->request('GET',$lin);
			if($response->getStatusCode() == 200){
				return $next($request);
			} else {
				return redirect('/login');
			}

			
		} else {
			return redirect('/login');
		}

        
    }
}
