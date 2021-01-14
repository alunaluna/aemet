@extends('layouts.app')

@section('title', 'Web graffitis')

@section('content')

	<!-- FORMULIARIO BUSQUEDA -->
	<form class="form-row pt-5" action="{{url('/buscar')}}" method="post">
		@csrf
		<div class="col-4">
			<select class="form-control">
				<option>Busqueda por título</option>
			</select>
		</div>
		<div class="col-6">
			<input type="text" class="form-control" name="texto">
		</div>
		<div class="col-2">
			<!--<a href="" class="btn-guay scrollto">Buscar</a>-->
			<button type="submit" class="btn btn-guay btn-block">Buscar</button>
		</div>
	</form>
	<!-- FIN FORMULIARIO BUSQUEDA-->
	<div class="col-12 pt-4">
		<hr style="border: 1px solid white">
	</div>

	<!-- FOTOS -->

	<div class="relative flex justify-center pt-4">
		<div class="card-columns">
			@foreach($graffitis as $g)
				<div class="card card-flotante">
					<a href="{{ url('/graffiti/'.$g['_id']) }}">
						<img src="{{ $g['url_foto'] }}" class="card-img-top">
					</a>
					<div class="card-body post_feed">
						<h5 class="card-title"><a href="{{ url('/graffiti/'.$g['_id']) }}">{{ $g['titulo']}}</a></h5>
						<h6 class="card-subtitle mb-2 font-weight-bold">{{$g['autor']}}</h6>
						<p class="card-text">{{ $g['descripcion']}}</p>
					</div>
				</div>
			@endforeach
		</div>
	</div>
	<!-- FIN FOTOS -->

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