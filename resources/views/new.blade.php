<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Web Graffiti</title>

	<!-- Fonts -->
	<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

	<!-- Styles -->
	<link href="css/app.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
	<link rel="stylesheet" href="owlcarousel/owl.carousel.min.css" />
	<link rel="stylesheet" href="owlcarousel/owl.theme.default.min.css">

	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
	<script src="owlcarousel/owl.carousel.min.js"></script>

</head>

<body id="main">
	<!-- ======= Header ======= -->
	<header id="header" class="fixed-top">
		<div class="container d-flex align-items-center">
			<h1 class="logo mr-auto text-light"><a href="/">Web Graffiti<span></span></a></h1>
		</div>
	</header><!-- .nav-menu -->


	<div class="container pt-5 mt-5">

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
		<form class="form-row mt-4" action="/new" method="post">
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
				<button type="submit" class="btn-guay mt-4">Crear graffiti</button>
			</div>
		</form>
		<!-- FIN FORMULIARIO -->
		<div class="col-12 pt-4">
			<hr style="border: 1px solid white">
		</div>

	</div>

</body>

<script>

</script>

</html>