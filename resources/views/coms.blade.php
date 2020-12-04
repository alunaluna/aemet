@extends('layouts.app')

@section('title', $graffiti['titulo'].' - Web graffitis')

@section('content')

	<!-- POST (FOTO) -->
	<div class="row pt-3 mt-3 post-ampliado">
		<!-- Mitad de la foto -->
		<div class="col-6">
			<div class="card border-0">
				<div class="card-header">Post de <a href="{{url("/user/".$poster["_id"])}}">{{$poster['username']}}</a></div>
				<img src="{{ $graffiti['url_foto'] }}" class="card-img-top">
				<div class="card-body">
					<h5 class="card-title">{{ $graffiti['titulo']}}</h5>
					<h6 class="card-subtitle mb-2 text-muted">{{$graffiti['autor']}}</h6>
					<p class="card-text">{{ $graffiti['descripcion']}}</p>
				</div>
			</div>
		</div>

		<!-- Mitad de los comentarios -->
		<div class="col-6">
			<h3>Nuevo comentario</h3>
			<form class="form" action="{{ url('/comentar') }}" method="post">
				@csrf
				<input type="hidden" name="graffiti_id" value="{{$graffiti['_id']}}">
				<div class="form-group">
					<textarea class="form-control" rows="3" name="texto"></textarea>
				</div>
				<div class="form-group row">
					<label class="col-form-label col-4">Enviar como usuario:</label>
					<select class="form-control col-4" name="usuario_id">
						@foreach($usuarios as $u)
						<option value="{{ $u['_id'] }}">{{ $u['username'] }}</option>
						@endforeach
					</select>
					<div class="col-4">
						<button type="submit" class="btn btn-guay">Enviar comentario</button>
					</div>
				</div>
			</form>
			<h3 class="text mt-2">Comentarios</h3>
			<div class="list-group pb-3">
				@foreach($comentarios as $c)
				<div class="list-group-item list-group-item-action flex-column align-items-start">
					<div class="d-flex w-100 justify-content-between">
						<h5 class="mb-1"><a href="{{url("/user/".$c['usuario_id'])}}">{{ $usuarios[$c['usuario_id']]['username']}}</a></h5>
						<small>{{Carbon\Carbon::parse($c['created_at'])->format('d M yy')}}</small>
					</div>
					<p class="mb-1">{{$c['texto']}}</p>
					<!--<small>Podemos poner aqui mg o algo</small>-->
				</div>
				@endforeach
			</div>
		</div>
	</div>
	<!-- FIN DEL POST-->


	<div class="col-12 pt-4">
		<hr style="border: 1px solid white">
	</div>

	<!-- MAPA -->
	<h3 class="pt-3 pb-3" style="color:white">Ubicación del graffiti</h3>
	<div class="container pt-1 mt-1">
		@map([
			'lat' => $graffiti['latitud'],
			'lng' => $graffiti['longitud'],
			'zoom' => 6,
			'markers' => [
				[
				'title' => $graffiti['titulo'],
				'lat' => $graffiti['latitud'],
				'lng' => $graffiti['longitud'],
				],
			],
		])
	</div>
	<!-- FIN DEL MAPA -->

	<div class="col-12 pt-4">
		<hr style="border: 1px solid white">
	</div>

	<!-- CARROUSEL EVENTOS -->
	<h3 class="pt-3 pb-3" style="color:white">Eventos de este mes en Málaga</h3>
	<div class="owl-carousel">
		@foreach($eventos as $e)
		<div class="evento">
			<h5 class="titulo-evento pt-2">{{$e['NOMBRE']}}</h5>
			<div class="enlace-evento"><a href="{{ url($e['DIRECCION_WEB'])}}" target="_blank">{{$e['DIRECCION_WEB']}}</a> </div>
			<div class="descripcion-evento pt-2">{{substr($e['DESCRIPCION'],0,100).'...'}}</div>
			<div class="fechas-evento pt-2 font-weight-bold" style="vertical-align: bottom">Inicio: {{substr($e['F_INICIO'],0,10)}} Fin: {{substr($e['F_FIN'],0,10)}}</div>
		</div>
		@endforeach
	</div>
	<!-- FIN CARROUSEL EVENTOS -->
	
@endsection