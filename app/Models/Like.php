<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Like extends Model
{
	use HasFactory;

	protected $fillable = [
		'usuario_id',
		'graffiti_id',
		'isLike',
	];

	protected $attributes = [
        'isLike' => true,
    ];

	//Relaciones
    public function usuario(){
    	return $this->belongsTo('App\Models\Usuario');
    }

	public function graffiti(){
        return $this->belongsTo('App\Models\Graffiti');
	}

	//Funciones auxiliares
	public static function busqueda($usuario_id, $graffiti_id){
		return Like::where('usuario_id', 'like', $usuario_id)
					->where('graffiti_id', 'like', $graffiti_id)
					->first();
	}
}
