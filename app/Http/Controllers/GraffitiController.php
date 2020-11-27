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

		return response()->view('coms', ['graffiti' => $graffiti, 'comentarios'=>$comentarios]);

	}
}
