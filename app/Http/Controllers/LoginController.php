<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Imgur;
use function PHPUnit\Framework\isEmpty;

class LoginController extends Controller
{
    public function index(){
        return response()->view('login');
    }

    public function redirect(){
        return Socialite::driver('google')->redirect();
    }

    public function callback(){
        $email = Socialite::driver('google')->stateless()->user()->getEmail();
        request()->session()->put('email', $email);

        $client = new Client([
            'base_uri' => '',
        ]);

        $lin = sprintf(env('API_URL_HEROKU') .'api/usuarios/porEmail/%s',$email);

        $response = $client->request('GET',$lin);

        $response = json_decode($response->getBody(), true);

        if(sizeof($response)==0){ //si ese correo no tiene entrada en la base de datos, entonces pasamos a crear una cuenta
            return response()->view('register');
        }else{ //si ese correo ya está registrado, entonces palante
            return redirect('/');
        }
    }

    public function store(){
        $client = new Client([
            'base_uri' => '',
        ]);

        $request_form = request()->all();

        $request_form['email'] = request()->session()->get('email');

        $image = Imgur::setHeaders([
            'headers' => [
                'authorization' => 'Client-ID ' . env('IMGUR_CLIENT_ID'),
            ]
        ])->upload(request()->image);

        $request_form['foto_perfil'] = $image->link();

        $response = $client->post(env('API_URL_HEROKU') .'api/usuarios', ['json' => $request_form]);

        $response = $client->request('GET',env('API_URL_HEROKU') .'api/usuarios');
        $users = json_decode($response->getBody(), true);

        $resp = [
            'alert' => 'Graffiti creado correctamente',
            'users' => $users,
        ];

        return redirect('/');
    }
}
