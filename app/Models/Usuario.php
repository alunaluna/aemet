<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Jenssegers\Mongodb\Auth\User as Authenticatable;


class Usuario extends Authenticatable
{
	protected $fillable = [
		'username',
		'nombre',
		'apellido',
		'ubicacion',
		'email',
		'password',
		'foto_perfil',
		'descripcion',
		'provider_id'
	];

	// Relaciones
	public function graffitis()
	{
		return $this->hasMany('App\Models\Graffiti');
	}

	public function comentarios()
	{
		return $this->hasMany('App\Models\Comentario');
	}

	public function likes()
	{
		return $this->hasMany(Like::class);
	}

	public function seguidores()
	{
		return $this->hasMany(Follower::class, 'follower');
	}

	public function siguiendo()
	{
		return $this->hasMany(Follower::class, 'usuario_id');
	}

	// Funciones auxiliares
	public static function findRange($id1, $id2)
	{
		return Usuario::where('id', '>=', $id1)->where('id', '<=', $id2)->get();
	}

	public static function searchByName($name)
	{
		return Usuario::where('nombre', 'like', '%' . $name . '%')->get();
	}

	public static function findByEmail($email)
	{
		return Usuario::where('email', 'like', $email)->first();
	}

	public static function fans($id)
	{
		$user = Usuario::findOrFail($id);
		$graffitis = $user->graffitis()->get();

		$comentarios = new Collection();
		foreach ($graffitis as $g) {
			$comentarios = $comentarios->merge($g->comentarios()->get());
		}

		$fans = new Collection();
		foreach ($comentarios as $c) {
			$fans = $fans->merge($c->usuario()->get());
		}
		return $fans;
	}
}
