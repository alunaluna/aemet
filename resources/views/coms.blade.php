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
		<!-- POST (FOTO) -->
		<div class="row pt-3 mt-3 post-ampliado">
			<!-- Mitad de la foto -->
			<div class="col-6">
				<div class="card border-0">
					<div class="card-header">Post de <a href="/user/{{$poster["_id"]}}">{{$poster['username']}}</a></div>
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
				<h3 class="text">Nuevo comentario</h3>
				<form class="form mt-2" action="/comentar" method="post">
					@csrf
					<input type="hidden" name="graffiti_id" value="{{$graffiti['_id']}}">
					<textarea class="form-control" rows="3" name="texto"></textarea>
					<div class="row">
						<div class="form-group col-6">
							<label>Enviar como usuario:</label>
							<select class="form-control" name="usuario_id">
								@foreach($usuarios as $u)
								<option value="{{ $u['_id'] }}">{{ $u['username'] }}</option>
								@endforeach
							</select>
						</div>
						<div class="col-6">
							<button type="submit" class="btn-guay scrollto ml-0 mt-4">Enviar comentario</button>
						</div>
					</div>
				</form>
				<h3 class="text mt-2">Comentarios</h3>
				<div class="list-group pb-3">
					@foreach($comentarios as $c)
					<div class="list-group-item list-group-item-action flex-column align-items-start">
						<div class="d-flex w-100 justify-content-between">
							<h5 class="mb-1"><a href="/user/{{$c['usuario_id']}}">{{ $usuarios[$c['usuario_id']]['username']}}</a></h5>
							<small>{{Carbon\Carbon::parse($c['created_at'])->format('d M yy')}}</small>
						</div>
						<p class="mb-1">{{$c['texto']}}</p>
						<small>Podemos poner aqui mg o algo</small>
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