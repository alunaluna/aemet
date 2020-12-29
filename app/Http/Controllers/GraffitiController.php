<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Imgur;

class GraffitiController extends Controller
{
    public function index(){

		$client = new Client([
			'base_uri' => '',
		]);

		$response = $client->request('GET',env('API_URL_HEROKU') .'api/graffitis');

		$graffitis = json_decode($response->getBody(), true);

        $mes = date("m", time());

		$response = $client->request('GET',env('API_URL_HEROKU') .'api/datosAbiertos/eventos/mes/'.$mes);

		$eventos = json_decode($response->getBody(), true);

		$eventosListaReducida = array_slice($eventos, 0, 20);  //Debería haber algún endpoint que devolviese un # acotado de eventos

		$eventosCorregidos = GraffitiController::corregirEventos($eventosListaReducida);

		return response()->view('feed', ['graffitis' => $graffitis, 'eventos' => array_slice($eventosCorregidos, 0, 20)]);
	}

	public function show($id){
		$client = new Client([
			'base_uri' => '',
		]);

		$lin = sprintf(env('API_URL_HEROKU') .'api/graffitis/%s/comentarios',$id);

		$response = $client->request('GET',$lin);

		$comentarios = json_decode($response->getBody(), true);

		$lin = sprintf(env('API_URL_HEROKU') .'api/graffitis/%s',$id);

		$response = $client->request('GET',$lin);

		$graffiti = json_decode($response->getBody(), true);

		$lin = sprintf(env('API_URL_HEROKU') .'api/usuarios/%s', $graffiti['usuario_id']);

		$response = $client->request('GET',$lin);

		$poster = json_decode($response->getBody(), true);

		$mes = date("m", strtotime($graffiti['created_at']));

		$lin = sprintf(env('API_URL_HEROKU') .'api/datosAbiertos/eventos/mes/%s',$mes);

		$response = $client->request('GET',$lin); //ralentiza la carga de la página, quizas es mejor quitarlo.

		$eventos = GraffitiController::corregirEventos(array_slice(json_decode($response->getBody(), true), 0, 20));

		$usuarios = array();

		$response = $client->request('GET',env('API_URL_HEROKU') .'api/usuarios');

		$users = json_decode($response->getBody(), true);
		
		foreach($users as $u){
			$usuarios[$u['_id']] = $u;
		}

		$tweet = 'Mira este graffiti de '.$graffiti['autor'].' en '.url()->current();

		$resp = [
			'eventos' => $eventos,
			'graffiti' => $graffiti,
			'comentarios' => $comentarios,
			'usuarios' => $usuarios,
			'poster' => $poster,
			'tweet' => $tweet
		];

		return response()->view('coms', $resp);
	}

	public function new(){
		$client = new Client([
			'base_uri' => '',
		]);

		$response = $client->request('GET',env('API_URL_HEROKU') .'api/usuarios');

		$users = json_decode($response->getBody(), true);

		$resp = [
			'users' => $users,
		];

		return response()->view('new', $resp);
	}

	public function search(){
		$client = new Client([
			'base_uri' => '',
		]);

		$text = strval(request()->input('texto'));
		if(empty($text)){
			$lin = sprintf(env('API_URL_HEROKU') .'api/graffitis');
		} else {
			$lin = sprintf(env('API_URL_HEROKU') .'api/graffitis/porTitulo/%s',$text);
		}
		
		$response = $client->request('GET', $lin);

		$graffitis = json_decode($response->getBody(), true);

		$mes = date("m", time());

		$response = $client->request('GET',env('API_URL_HEROKU') .'api/datosAbiertos/eventos/mes/'.$mes);

		$eventos = json_decode($response->getBody(), true);

		$eventosListaReducida = array_slice($eventos, 0, 20);  //Debería haber algún endpoint que devolviese un # acotado de eventos

		$eventosCorregidos = GraffitiController::corregirEventos($eventosListaReducida);

		$resp = [
			'eventos' => $eventosCorregidos,
			'graffitis' => $graffitis,
		];

		return response()->view('feed', $resp);
	}

	public function store(){
		$client = new Client([
			'base_uri' => '',
		]);
		$request_form = request()->all();
		if(empty($request_form['autor'])){
			$request_form['autor'] = 'Anónimo'; //si el autor está vació, lo ponemos como anónimo
		}

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

		return response()->view('new', $resp);
	}

	public function subirImagenImgur($url) {
		$image = Imgur::setHeaders([
			'headers' => [
				'authorization' => 'Client-ID ' . env('IMGUR_CLIENT_ID'),
			]
		])->upload($url);
		return $image->link();
	}

	private static function corregirEventos($eventos){
		foreach ($eventos as &$ev ) {
			$ev['NOMBRE'] = GraffitiController::eliminarHtmlTags($ev['NOMBRE']);
			$ev['DESCRIPCION'] = GraffitiController::eliminarHtmlTags($ev['DESCRIPCION']);
			$ev['DIRECCION_WEB'] = ($ev['DIRECCION_WEB']!='') ? 'http://'.$ev['DIRECCION_WEB']:'';
		}
		return $eventos;
	}


    public static function eliminarHtmlTags($cadena){

        while(($inicioEtiquetaHtml  = strpos($cadena, '<')) !== false ){

            $finalEtiquetaHtml = strpos($cadena, '>');
            if($finalEtiquetaHtml !== false){
                $longitud =  $finalEtiquetaHtml - $inicioEtiquetaHtml + 1;
                $htmlTag = substr($cadena, $inicioEtiquetaHtml, $longitud);
                $cadena = str_replace($htmlTag, "", $cadena);
            }
        }
        return $cadena;
    }
}


