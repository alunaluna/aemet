<?php

namespace App\Http\Controllers;

use App\Models\Graffiti;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Imgur;

class GraffitiController extends Controller
{
    public function index(){
		$graffitis = Graffiti::orderByDesc('created_at')->get();

		$datos = new DatosAbiertosHelper();
		$eventos = $datos->eventosDelMes(date("m", time()));
		$eventosListaReducida = array_slice($eventos, 0, 20);  //Debería haber algún endpoint que devolviese un # acotado de eventos
		$eventosCorregidos = $this->corregirEventos($eventosListaReducida);

		return response()->view('feed', ['graffitis' => $graffitis, 'eventos' => array_slice($eventosCorregidos, 0, 20)]);
	}

	public function show($id){

		$graffiti = Graffiti::findOrFail($id);

		$comentarios = $graffiti->comentarios;

		$poster = $graffiti->usuario;

		$datos = new DatosAbiertosHelper();
		$eventos = $this->corregirEventos($datos->eventosDelMes(date("m", strtotime($graffiti->created_at))));

		$usuarios = Usuario::all();

		$tweet = 'Mira este graffiti de '.$graffiti['autor'].' en '.url()->current();

		$resp = [
			'eventos' => $eventos,
			'graffiti' => $graffiti,
			'comentarios' => $comentarios,
			'usuarios' => $usuarios,
			'poster' => $poster,
			'tweet' => $tweet
		];

		return response()->view('graffiti', $resp);
	}


	public function search(Request $request){

		$text = strval($request->input('texto'));
		if(empty($text)){
			$graffitis = Graffiti::all();
		} else {
			$graffitis = Graffiti::searchByTitulo($text);
		}

		$datos = new DatosAbiertosHelper();
		$eventos = $datos->eventosDelMes(date("m", time()));
		$eventosListaReducida = array_slice($eventos, 0, 20);  //Debería haber algún endpoint que devolviese un # acotado de eventos
		$eventosCorregidos = $this->corregirEventos($eventosListaReducida);

		$resp = [
			'eventos' => $eventosCorregidos,
			'graffitis' => $graffitis,
		];

		return response()->view('feed', $resp);
	}

	public function store(Request $request){

		$request_form = $request->all();

		$request_form['usuario_id'] = Auth::user()->id;

		if(empty($request_form['autor'])){
			$request_form['autor'] = 'Anónimo'; //si el autor está vació, lo ponemos como anónimo
		}

		$image = Imgur::setHeaders([
			'headers' => [
				'authorization' => 'Client-ID ' . env('IMGUR_CLIENT_ID'),
			]
		])->upload(request()->image);

		$request_form['url_foto'] = $image->link();

		Graffiti::create($request_form);

		$resp = [
			'alert' => 'Graffiti creado correctamente',
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

	private function corregirEventos($eventos){
		foreach ($eventos as &$ev ) {
			$ev['NOMBRE'] = $this->eliminarHtmlTags($ev['NOMBRE']);
			$ev['DESCRIPCION'] = $this->eliminarHtmlTags($ev['DESCRIPCION']);
			$ev['DIRECCION_WEB'] = ($ev['DIRECCION_WEB']!='') ? 'http://'.$ev['DIRECCION_WEB']:'';
		}
		return $eventos;
	}


    public function eliminarHtmlTags($cadena){

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


