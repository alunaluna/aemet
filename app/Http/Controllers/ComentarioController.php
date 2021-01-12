<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    public function store(Request $request){
        $comentario = Comentario::create($request->all());
        return redirect()->back();
    }
}
