<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Graffiti extends Model
{

    protected $fillable = [
        'titulo',
        'autor',
        'descripcion',
        'url_foto',
		'latitud',
		'longitud',
        'usuario_id'
    ];

	//Relaciones
    public function usuario(){
    	return $this->belongsTo('App\Models\Usuario');
    }

    public function comentarios(){
        return $this->hasMany(Comentario::class);
	}
	
	public function likes(){
        return $this->hasMany('App\Models\Like');
	}

	//Funciones auxiliares
	public static function findRange($id1,$id2){
        return Graffiti::where('id', '>=', $id1)->where('id', '<=', $id2)->get();
	}

    public static function searchByTitulo($titulo){
        return Graffiti::where('titulo', 'like', '%'.$titulo.'%')->get();
	}
	
	// public function likesTotales(){
    //     return $this->likes()->count();
	// }


}
