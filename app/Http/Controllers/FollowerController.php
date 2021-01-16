<?php

namespace App\Http\Controllers;

use App\Models\Follower;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    public function store($usuario_id){
        $follower = auth()->user()->id;
        if(!Follower::busqueda($usuario_id, $follower)){
            Follower::create([
                'usuario_id' => $usuario_id,
                'follower' => $follower
            ]);
        }
        return redirect()->back();
    }

    public function delete($follow_id){
        $follow = Follower::findOrFail($follow_id);

        if($follow && $follow->follower == auth()->user()->id){
            $follow->delete();
        }

        return redirect()->back();
    }
}
