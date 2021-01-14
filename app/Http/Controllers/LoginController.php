<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Imgur;


class LoginController extends Controller
{
    public function index(){
        return response()->view('login');
	}
	
	public function logout(Request $request) {
		Auth::logout();
		return redirect('/');
	  }

    public function redirect(){
        return Socialite::driver('google')->redirect();
    }

    public function callback(){
		$user = Socialite::driver('google')->stateless()->user();

		$usuario = Usuario::findByEmail($user->getEmail());

        if($usuario){ //si ese correo ya está registrado, entonces palante
			auth()->login($usuario);
            return redirect('/');
		}else{ //si ese correo no tiene entrada en la base de datos, entonces pasamos a crear una cuenta
			$newUser = Usuario::create([
									'nombre' => $user->getName(),
									'email' => $user->getEmail(),
									'provider_id' => $user->getId(),
								]);
			return response()->view('register', ['usuario' => $newUser]);
        }
    }

    public function store(Request $request){

        $request_form = request()->all();

        $image = Imgur::setHeaders([
            'headers' => [
                'authorization' => 'Client-ID ' . env('IMGUR_CLIENT_ID'),
            ]
        ])->upload(request()->image);

		$request_form['foto_perfil'] = $image->link();

		$usuario = Usuario::find($request_form['id']);

        $usuario->update($request_form);

		auth()->login($usuario);
        return redirect('/');
	}
	
	public function profile(){

        $graffitis_usuario = auth()->user()->graffitis;

        $resp = [
			'graffitis' => $graffitis_usuario,
			'n_graffitis' => count($graffitis_usuario),
        ];

        return response()->view('profile', $resp);
    }
}
