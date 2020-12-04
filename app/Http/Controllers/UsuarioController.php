<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index($id){

        $client = new Client([
            'base_uri' => '',
        ]);

        $lin = sprintf('http://graffitiserver.herokuapp.com/public/api/usuarios/%s',$id);

        $response = $client->request('GET',$lin); //ralentiza la carga de la página, quizas es mejor quitarlo.

        $usuario = json_decode($response->getBody(), true);

        $lin = sprintf('http://graffitiserver.herokuapp.com/public/api/usuarios/%s/graffitis',$id);

        $response = $client->request('GET',$lin); //ralentiza la carga de la página, quizas es mejor quitarlo.

        $graffitis_usuario = json_decode($response->getBody(), true);

        $resp = [
            'usuario' => $usuario,
            'graffitis' => $graffitis_usuario,
        ];

        return response()->view('user', $resp);
    }
}
