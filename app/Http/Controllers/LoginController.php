<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function index(){
        return response()->view('login');
    }

    public function redirect(){
        return response()->view('register');
        //return Socialite::driver('google')->redirect();
    }

    public function callback(){
        $email = Socialite::driver('google')->user();
        request()->session()->put(['usuario', $email]);

        $client = new Client([
            'base_uri' => '',
        ]);

        $lin = sprintf(env('API_URL_HEROKU') .'api/usuarios/email/%s',$email);

        $response = $client->request('GET',$lin);

        if($response == null){ //si ese correo no tiene entrada en la base de datos, entonces pasamos a crear una cuenta
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

        $request_form['url_foto'] = $image->link();

        $response = $client->post(env('API_URL_HEROKU') .'api/graffitis', ['json' => $request_form]);

        $response = $client->request('GET',env('API_URL_HEROKU') .'api/usuarios');
        $users = json_decode($response->getBody(), true);

        $resp = [
            'alert' => 'Graffiti creado correctamente',
            'users' => $users,
        ];

        return redirect('/');
    }
}
