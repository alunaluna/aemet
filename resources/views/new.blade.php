@extends('layouts.app')

@section('title', 'Nuevo graffiti - Web graffitis')

@section('content')

		@if(isset($alert))
		<!-- ALERT -->
		<div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
			{{$alert}}
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<!-- /ALERT -->
		@endif

		<!-- FORMULIARIO -->
		<form class="form-row mt-4" action="{{url('/new')}}" method="post">
			@csrf
			<div class="form-group col-4">
				<label class="label">Título</label>
				<input type="text" class="form-control" name="titulo">
			</div>
			<div class="form-group col-4">
				<label class="label">Descripción</label>
				<input type="text" class="form-control" name="descripcion">
			</div>
			<div class="form-group col-4">
				<label class="label">Autor</label>
				<input type="text" class="form-control" name="autor">
			</div>
			<div class="form-group col-8">
				<label class="label">URL</label>
				<input type="text" class="form-control" name="url_foto">
			</div>
			<div class="form-group col-2">
				<label class="label">Latitud</label>
				<input type="text" class="form-control" name="latitud">
			</div>
			<div class="form-group col-2">
				<label class="label">Longitud</label>
				<input type="text" class="form-control" name="longitud">
			</div>
			<div class="form-group col-4">
				<label class="label">Usuario</label>
				<select class="form-control" name="usuario_id">
					@foreach($users as $u)
					<option value="{{ $u['_id'] }}">{{ $u['username'] }}</option>
					@endforeach
				</select>
			</div>
			<div class="form-group col-4">
				<button type="submit" class="btn btn-guay" style="margin-top:2rem">Crear graffiti</button>
			</div>
		</form>

@endsection