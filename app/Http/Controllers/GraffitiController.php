<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class GraffitiController extends Controller
{
    public function index(){

		$client = new Client([
			'base_uri' => '',
		]);

		$response = $client->request('GET','http://graffitiserver.herokuapp.com/public/api/graffitis');

		$graffitis = json_decode($response->getBody(), true);

        $mes = date("m", time());

		$response = $client->request('GET','http://graffitiserver.herokuapp.com/public/api/datosAbiertos/eventos/mes/'.$mes);

		$eventos = json_decode($response->getBody(), true);

		$eventosListaReducida = array_slice($eventos, 0, 20);  //Debería haber algún endpoint que devolviese un # acotado de eventos

		$eventosCorregidos = GraffitiController::corregirEventos($eventosListaReducida);

		return response()->view('feed', ['graffitis' => $graffitis, 'eventos' => array_slice($eventosCorregidos, 0, 20)]);
	}

	public function show($id){
		$client = new Client([
			'base_uri' => '',
		]);

		$lin = sprintf('http://graffitiserver.herokuapp.com/public/api/graffitis/%s/comentarios',$id);

		$response = $client->request('GET',$lin);

		$comentarios = json_decode($response->getBody(), true);

		$lin = sprintf('http://graffitiserver.herokuapp.com/public/api/graffitis/%s',$id);

		$response = $client->request('GET',$lin);

		$graffiti = json_decode($response->getBody(), true);

		$mes = date("m", strtotime($graffiti['created_at']));

		$lin = sprintf('http://graffitiserver.herokuapp.com/public/api/datosAbiertos/eventos/mes/%s',$mes);

		$response = $client->request('GET',$lin); //ralentiza la carga de la página, quizas es mejor quitarlo.

		$eventos = GraffitiController::corregirEventos(array_slice(json_decode($response->getBody(), true), 0, 20));

		$usuarios = array();

		$response = $client->request('GET','http://graffitiserver.herokuapp.com/public/api/usuarios');

		$users = json_decode($response->getBody(), true);

		foreach($users as $u){
			$usuarios[$u['_id']] = $u;
		}

		$resp = [
			'eventos' => $eventos,
			'graffiti' => $graffiti,
			'comentarios' => $comentarios,
			'usuarios' => $usuarios,
		];

		return response()->view('coms', $resp);
	}

	public function new(){
		$client = new Client([
			'base_uri' => '',
		]);

		$response = $client->request('GET','http://graffitiserver.herokuapp.com/public/api/usuarios');

		$users = json_decode($response->getBody(), true);

		$resp = [
			'users' => $users,
		];

		return response()->view('new', $resp);
	}

	public function store(){
		$client = new Client([
			'base_uri' => '',
		]);

		$response = $client->post('http://graffitiserver.herokuapp.com/public/api/graffitis', ['json' => request()->all()]);

		$response = $client->request('GET','http://graffitiserver.herokuapp.com/public/api/usuarios');
		$users = json_decode($response->getBody(), true);

		$resp = [
			'alert' => 'Graffiti creado correctamente',
			'users' => $users,
		];

		return response()->view('new', $resp);

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


