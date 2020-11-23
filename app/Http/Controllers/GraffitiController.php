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
}
