@extends('layouts.app')

@section('title', 'Pagina personal de '.auth()->user()->username)

@section('content')

    <!-- PERFIL -->
        <div class="row perfil mt-5">
            <div class="col-3 p-5">
                <img src="{{ auth()->user()->foto_perfil }}" class="rounded-circle pl-2">
            </div>
            <div class="col-9 pt-5">
                <div>
                    <h1>{{ auth()->user()->username }}</h1>
					<a href="{{ url('/user/'.auth()->user()->id ) }}" class="btn btn-guay">Ver perfil público</a>
                    <a href="#" class="btn btn-guay">Editar perfil</a>
                </div>
                <div class="d-flex">
                    <div class="pt-2 pr-5">Has descubierto <strong>{{ $n_graffitis }}</strong> @if($n_graffitis == 1) graffiti @else graffitis @endif</div>
                </div>
                <div class="pt-2">
                    {{ auth()->user()->descripcion }}
					{{ request()->session()->get('expiresDate') }}
                </div>
	        </div>
        </div>
    <!-- FIN PERFIL -->

    <div class="col-12 pt-4">
        <hr style="border: 1px solid white">
    </div>

    <!-- POST USUARIO -->
    <h1 style="color:white">Tus graffitis descubiertos</h1>
	@if($n_graffitis == 0) <p>No tienes graffitis. <a href="/new">Publica un post</a> para añadir un graffiti.</p> @endif
    <div class="relative flex justify-center pt-4">
        <div class="card-columns">
            @foreach($graffitis as $g)
				<div class="card card-flotante">
					<a href="{{ url('/graffiti/'.$g['_id']) }}">
						<img src="{{ $g['url_foto'] }}" class="card-img-top">
					</a>
					<div class="card-body post_feed">
						<h5 class="card-title"><a href=" {{url('/graffiti/'.$g['_id']) }}">{{ $g['titulo']}}</a></h5>
						<h6 class="card-subtitle mb-2 font-weight-bold">{{$g['autor']}}</h6>
						<p class="card-text">{{ $g['descripcion']}}</p>
					</div>
				</div>
            @endforeach
        </div>
    </div>
    <!-- FIN POST USUARIO -->

@endsection
