<?php

namespace App\Http\Controllers;

use App\Models\Usuario;

class UsuarioController extends Controller
{
    public function index($id){

        $usuario = Usuario::findOrFail($id);

        $graffitis_usuario = $usuario->graffitis;

        $resp = [
            'usuario' => $usuario,
			'graffitis' => $graffitis_usuario,
			'n_graffitis' => count($graffitis_usuario),
        ];

        return response()->view('user', $resp);
    }
}
