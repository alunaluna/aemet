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

	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</head>

<body id="main">
<!-- ======= Header ======= -->
<header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">
        <h1 class="logo mr-auto text-light"><a href="index.html">Web Graffiti<span></span></a></h1>

        <a href="" class="btn-guay scrollto">Nuevo Post</a>
    </div>
</header><!-- .nav-menu -->


<div class="container pt-5 mt-5">

<!-- FORMULIARIO -->
    <form class="form pt-5">
        <div class="row">
        <div class="col-4">
            <select class="form-control">
                <option>Busqueda por título</option>
            </select>
        </div>
        <div class="col-6">
            <input type="text" class="form-control">
        </div>
        <div class="col-2">
            <a href="" class="btn-guay scrollto">Buscar</a>
        </div>
        </div>
    </form>
<!-- FIN FORMULIARIO -->
    <div class="col-12 pt-4">
        <hr style="border: 1px solid white">
    </div>
<!-- FOTOS -->

    <div class="relative flex justify-center pt-4">
		<div class="row">
			@foreach($graffitis as $g)
			<div class="col-4 p-2">
				<div class="card card-flotante border-0">
					<img src="{{ $g['url_foto'] }}" class="card-img-top" >
					<div class="card-body post_feed">
						<h5 class="card-title"><a href ="comsa/{{ $g['_id'] }}">{{ $g['titulo']}}</a></h5>
						<h6 class="card-subtitle mb-2 font-weight-bold">{{$g['autor']}}</h6>
						<p class="card-text">{{ $g['descripcion']}}</p>
					</div>
				</div>
			</div>
			@endforeach
		</div>
	</div>
<!-- FIN FOTOS -->

</div>

</body>

</html>
