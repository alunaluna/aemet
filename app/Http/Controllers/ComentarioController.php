<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    public function store(){

        $id_graffiti = request()['graffiti_id'];

        $client = new Client([
            'base_uri' => '',
        ]);

        $response = $client->post(env('API_URL_HEROKU') .'api/comentarios', ['json' => request()->all()]);

        $resp = [];
        if($response->getStatusCode()==201){
            $resp = [
                'alert' => 'Graffiti creado correctamente',
            ];
        }

        return redirect('/comsa/'.$id_graffiti);
        //return response()->view('comsa/'.request()['id_graffiti'], $resp);
    }
}
