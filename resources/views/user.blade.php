@extends('layouts.app')

@section('title', 'Pagina personal de '. $usuario->username )

@section('content')

    <!-- PERFIL -->
        <div class="row perfil mt-5">
            <div class="col-3 p-5">
                <img src="{{ $usuario->foto_perfil }}" class="rounded-circle pl-2">
            </div>
            <div class="col-9 pt-5">
                <div>
                    <h1>{{ $usuario->username }}</h1>
                    @if(auth()->user() && auth()->user()->id != $usuario->id && !$follow)
                        <a href="{{url('/follow/'.$usuario->id)}}" class="btn btn-guay">Seguir</a>
                    @elseif(auth()->user() && $follow)
                        <a href="{{url('/unfollow/'.$follow->id)}}" class="btn btn-guay">Dejar de seguir</a>
                    @endif
                </div>
                <div class="d-flex">
                    <div class="pt-2 pr-5"><strong>{{ $n_graffitis }}</strong> @if($n_graffitis == 1) graffiti descubierto @else graffitis descubiertos @endif</div>
                </div>
                <div class="pt-2">
                    {{ $usuario->descripcion }}
					{{ request()->session()->get('expiresDate') }}
                </div>
	        </div>
        </div>
    <!-- FIN PERFIL -->

    <div class="col-12 pt-4">
        <hr style="border: 1px solid white">
    </div>

    <!-- POST USUARIO -->
	@if($n_graffitis > 0) 
    <h1 style="color:white"> Graffitis de {{ $usuario->username }}</h1>
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
	@endif
    <!-- FIN POST USUARIO -->

@endsection
