<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Laravel</title>

	<!-- Fonts -->
	<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

	<!-- Styles -->
	<link href="/css/app.css?v=14354" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
	<link rel="stylesheet" href="/owlcarousel/owl.carousel.min.css" />
	<link rel="stylesheet" href="/owlcarousel/owl.theme.default.min.css">

	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
	<script src="/owlcarousel/owl.carousel.min.js"></script>

	@mapstyles
</head>

<body id="main">
	<!-- ======= Header ======= -->
	<header id="header" class="fixed-top">
		<div class="container d-flex align-items-center">
			<h1 class="logo mr-auto text-light"><a href="/">Web Graffiti<span></span></a></h1>

			<a href="/new" class="btn-guay scrollto">Nuevo Post</a>
		</div>
	</header><!-- .nav-menu -->

<div class="container pt-5 mt-5">
		<div class="row pt-3 mt-3 post-ampliado">
			<div class="col-6">
				<div class="card border-0">
					<img src="{{ $graffiti['url_foto'] }}" class="card-img-top" >
					<div class="card-body">
						<h5 class="card-title">{{ $graffiti['titulo']}}</h5>
						<h6 class="card-subtitle mb-2 text-muted">{{$graffiti['autor']}}</h6>
						<p class="card-text">{{ $graffiti['descripcion']}}</p>
					</div>
				</div>
			</div>
			<div class="col-6">
                <h3 class="text">Nuevo comentario</h3>
                <form class="form mt-2" action="/comentar" method="post">
                    @csrf
                    <input type="hidden" name="usuario_id" value="{{'5fc1498e3021000054006905'}}"> <!--alvilux de ejemplo-->
                    <input type="hidden" name="graffiti_id" value="{{$graffiti['_id']}}">
                    <textarea class="form-control" rows="3" name="texto"></textarea>
                    <button type="submit" class="btn-guay scrollto ml-0 mt-2" >Enviar comentario</button>
                </form>
                <h3 class="text mt-2">Comentarios</h3>
				<div class="list-group pb-3">
                    @foreach($comentarios as $c)
                        <div class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">{{ $usuarios[$c['usuario_id']]['username']}}</h5>
                                <small>{{Carbon\Carbon::parse($c['created_at'])->format('d M yy')}}</small>
                            </div>
                            <p class="mb-1">{{$c['texto']}}</p>
                            <small>Podemos poner aqui mg o algo</small>
                        </div>
                    @endforeach
                    <!--<div class="card-body text-center">
						<h4 class="card-title">Comentarios</h4>
					</div>
					<div class="comment-widgets">
                        @foreach($comentarios as $c)
						<div class="d-flex flex-row comment-row m-t-0">
							<div class="comment-text w-100">
								<h6 class="font-medium">{{ $usuarios[$c['usuario_id']]['username']}}</h6> <span class="m-b-15 d-block">{{$c['texto']}}</span>
								<div class="comment-footer"><span class="text-muted float-right">{{Carbon\Carbon::parse($c['created_at'])->format('d M yy')}}</span> </div>
							</div>

						</div>
						@endforeach-->
					</div>
				</div>
			</div>
	<div class="col-12 pt-4">
		<hr style="border: 1px solid white">
	</div>
	<h3 class="pt-3 pb-3" style="color:white">Ubicacion del graffiti</h3>
	<div class="container pt-1 mt-1">
		@map([
    'lat' => 48.134664,
    'lng' => 11.555220,
    'zoom' => 6,
    'markers' => [
        [
            'title' => 'Go NoWare',
            'lat' => 48.134664,
            'lng' => 11.555220,
        ],
    ],
])
	</div>
	<!-- CARROUSEL EVENTOS -->
	<h3 class="pt-3 pb-3" style="color:white">Eventos de este mes en Málaga</h3>
	<div class="owl-carousel">
		@foreach($eventos as $e)
		<div class="evento">
			<h5 class="titulo-evento pt-2">{{$e['NOMBRE']}}</h5>
			<div class="enlace-evento"><a href="{{$e['DIRECCION_WEB']}}">{{$e['DIRECCION_WEB']}}</a> </div>
			<div class="descripcion-evento pt-2">{{substr($e['DESCRIPCION'],0,100).'...'}}</div>
			<div class="fechas-evento pt-2 font-weight-bold" style="vertical-align: bottom">Inicio: {{substr($e['F_INICIO'],0,10)}} Fin: {{substr($e['F_FIN'],0,10)}}</div>
		</div>
		@endforeach
	</div>
</div>
@mapscripts
</body>
<script>
	$(document).ready(function() {
		$(".owl-carousel").owlCarousel();
	});

	$('.owl-carousel').owlCarousel({
		loop: true,
		margin: 10,
		nav: true,
		responsive: {
			0: {
				items: 1
			},
			600: {
				items: 3
			}
		}
	})
</script>
</html>
