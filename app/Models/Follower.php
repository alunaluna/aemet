<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Follower extends Model
{
	use HasFactory;
	
	protected $fillable = [
		'usuario_id',
		'follower',
	];

	//Relaciones
    public function usuario(){
    	return $this->belongsTo('App\Models\Usuario' ,'usuario_id');
    }

	public function seguidor(){
        return $this->belongsTo('App\Models\Usuario', 'follower');
    }
}
