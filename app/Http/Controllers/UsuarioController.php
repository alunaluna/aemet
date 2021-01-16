<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Follower;

class UsuarioController extends Controller
{
    public function index($id){

        $usuario = Usuario::findOrFail($id);

        $follow = null;

        if(auth()->user()){
            $follow = Follower::busqueda( $id, auth()->user()->id);
        }

        $graffitis_usuario = $usuario->graffitis;

        $resp = [
            'usuario' => $usuario,
			'graffitis' => $graffitis_usuario,
            'n_graffitis' => count($graffitis_usuario),
            'follow' =>$follow,
        ];

        return response()->view('user', $resp);
    }
}
