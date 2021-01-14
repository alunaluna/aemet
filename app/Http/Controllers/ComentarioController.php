<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    public function store(Request $request){
		$request->request->add(['usuario_id' => auth()->user()->id]); //add usuario_id
        Comentario::create($request->all());
        return redirect()->back();
    }
}
