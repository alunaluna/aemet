<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Comentario extends Model
{

    protected $fillable = [
        'usuario_id',
        'graffiti_id',
        'texto',
        'fecha'
    ];

	//Relaciones
    public function usuario(){
    	return $this->belongsTo('App\Models\Usuario');
    }

    public function graffiti(){
    	return $this->belongsTo('App\Models\Graffiti');
    }

	// Funciones auxiliares
	public static function findRange($id1,$id2){
        return Usuario::where('id', '>=', $id1)->where('id', '<=', $id2)->get();
	}

    public static function searchByContent($contenido){
        return Comentario::where('texto', 'like', '%'.$contenido.'%')->get();
    }




}
