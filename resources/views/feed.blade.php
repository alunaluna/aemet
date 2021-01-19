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

    <!-- TIEMPO ATMOSFERICO -->

    <div class="card text-center col-4">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs justify-content-center" id="opciones-dias" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" href="#hoy" role="tab">Hoy</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#prox-semana" role="tab">Semana pr&oacute;xima</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <h4 class="card-title">M&aacute;laga</h4>
            <h6 class="card-subtitle mb-2">M&aacute;laga</h6>

            <div class="tab-content mt-3">
                <div class="tab-pane active" id="hoy" role="tabpanel">
                    <div class="row my-4">
                        <div class="col-3 my-3">
                            <h4>Hoy</h4>
                        </div>
                        <div class="col-5">
                            <p class="card-text">T. m&iacute;n. {{$tiempoHoy['temperatura']['minima']}} &#8451;</p>
                            <p class="card-text">T. m&aacute;x. {{$tiempoHoy['temperatura']['maxima']}} &#8451;</p>
                        </div>
                        <div class="col-3">
                            <i class="{{$tiempoHoy['tiempoIcono']}} fa-4x"></i>
                        </div>
                    </div>

                </div>

                <div class="tab-pane" id="prox-semana" role="tabpanel">
                    <div class="row">
                        <div class="col-4">
                            <h6>D&iacute;a</h6>
                        </div>
                        <div class="col-1">
                        </div>
                        <div class="col-3">
                            <h6>T. mín.</h6>
                        </div>
                        <div class="col-3">
                            <h6>T. máx.</h6>
                        </div>
                    </div>
                    @foreach($prediccionesProxSemana as $p)
                        <div class="row">

                            <div class="col-4">
                                {{$p['fecha']}}
                            </div>

                            <div class="col-1">
                                <i class="{{$p['tiempoIcono']}}"></i>
                            </div>
                            <div class="col-3">
                                {{$p['temperatura']['minima']}} &#8451;
                            </div>
                            <div class="col-3">
                                {{ $p['temperatura']['maxima']}} &#8451;
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- FIN TIEMPO ATMOSFERICO -->

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

    <script>
        $('#opciones-dias a').on('click', function (e) {
            e.preventDefault()
            $(this).tab('show')
        })
    </script>

@endsection
