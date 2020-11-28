<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class GraffitiController extends Controller
{
    public function index(){

		$client = new Client([
			'base_uri' => 'localhost:8069/',
		]);

		$response = $client->request('GET','api/graffitis');

		$graffitis = json_decode($response->getBody(), true);

		return response()->view('feed', ['graffitis' => $graffitis]);
		
	}

	public function show($id){
		$client = new Client([
			'base_uri' => 'localhost:8069/',
		]);

		$lin = sprintf('api/graffitis/%s/comentarios',$id);

		$response = $client->request('GET',$lin);

		$comentarios = json_decode($response->getBody(), true);

		$lin = sprintf('api/graffitis/%s',$id);

		$response = $client->request('GET',$lin);

		$graffiti = json_decode($response->getBody(), true);

		$mes = date("m", strtotime($graffiti['created_at']));

		$lin = sprintf('api/datosAbiertos/eventos/mes/%s',$mes);

		$response = $client->request('GET',$lin); //ralentiza la carga de la página, quizas es mejor quitarlo.

		$eventos = json_decode($response->getBody(), true);

		$usuarios = array();

		$response = $client->request('GET','api/usuarios');

		$users = json_decode($response->getBody(), true);

		foreach($users as $u){
			$usuarios[$u['id']] = $u; 
		}

		return response()->view('coms', ['eventos' => $eventos, 'graffiti' => $graffiti, 'comentarios' => $comentarios, 'usuarios' => $usuarios]);

	}
}
