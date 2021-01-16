<?php

namespace App\Http\Controllers;

use App\Models\Graffiti;
use App\Models\Like;
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

        $like = null;

        if(auth()->user()){
            $like = Like::busqueda(auth()->user()->id, $id);
        }

		$graffiti = Graffiti::findOrFail($id);

		$comentarios = $graffiti->comentarios;

		$datos = new DatosAbiertosHelper();
		$eventos = $this->corregirEventos($datos->eventosDelMes(date("m", strtotime($graffiti->created_at))));

		$usuarios = Usuario::all();

		$tweet = 'Mira este graffiti de '.$graffiti['autor'].' en '.url()->current();

		$resp = [
			'eventos' => $eventos,
			'graffiti' => $graffiti,
			'comentarios' => $comentarios,
			'usuarios' => $usuarios,
			'tweet' => $tweet,
            'like' => $like
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

		$request->request->add(['usuario_id' => Auth::user()->id]); //add usuario_id

		if(empty($request->autor)){ //si el autor está vacío, lo ponemos como anónimo
			$request->request->add(['autor' => 'Anónimo']);
		}

		$image = Imgur::setHeaders([
									'headers' => ['authorization' => 'Client-ID ' . env('IMGUR_CLIENT_ID'),
									]
								])->upload($request->image);

		$request->request->add(['url_foto' => $image->link()]); //add url_foto

		$graffiti = Graffiti::create($request->all());

		return redirect('graffiti/' . $graffiti->id )->with('alert', 'Post creado correctamente');
	}

	public function destroy($id){
		$graffiti = Graffiti::findOrFail($id);
		if(Auth::user()->id == $graffiti->usuario_id){
			$graffiti->delete();
		} else {
			return back()->with('alert', 'Error al eliminar el post.');
		}
        return redirect('/')->with(['alert' => 'Post eliminado correctamente.']);
    }

	public function subirImagenImgur($url) {
		$image = Imgur::setHeaders([
			'headers' => [
				'authorization' => 'Client-ID ' . env('IMGUR_CLIENT_ID'),
			]
		])->upload($url);
		return $image->link();
	}

	//Funciones auxiliares

	private function corregirEventos($eventos){
		foreach ($eventos as &$ev ) {
			$ev['NOMBRE'] = $this->eliminarHtmlTags($ev['NOMBRE']);
			$ev['DESCRIPCION'] = $this->eliminarHtmlTags($ev['DESCRIPCION']);
			$ev['DIRECCION_WEB'] = ($ev['DIRECCION_WEB']!='') ? 'http://'.$ev['DIRECCION_WEB']:'';
		}
		return $eventos;
	}

    private function eliminarHtmlTags($cadena){

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


