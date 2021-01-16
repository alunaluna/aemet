<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store($graffiti_id){
        $usuario_id = auth()->user()->id;
        if(!Like::busqueda($usuario_id, $graffiti_id)){
            Like::create([
                'usuario_id' => $usuario_id,
                'graffiti_id' => $graffiti_id
            ]);
        }
        return redirect()->back();
    }

    public function delete($like_id){
        $like = Like::findOrFail($like_id);

        if($like && $like->usuario_id == auth()->user()->id){
            $like->delete();
        }

        return redirect()->back();
    }
}
