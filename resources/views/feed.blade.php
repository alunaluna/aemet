<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Laravel</title>

	<!-- Fonts -->
	<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

	<!-- Styles -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</head>

<body class="container">
	<div class="relative flex justify-center">
		<div class="row">
			@foreach($graffitis as $g)
			<div class="col-4 p-2">
				<div class="card">
					<img src="{{ $g['url_foto'] }}" class="card-img-top p-3" >
					<div class="card-body">
						<a href ="comsa/{{ $g['id'] }}"><h5 class="card-title">{{ $g['titulo']}}</a></h5>
						<h6 class="card-subtitle mb-2 text-muted">{{$g['autor']}}</h6>
						<p class="card-text">{{ $g['descripcion']}}</p>
					</div>
				</div>
			</div>
			@endforeach
		</div>
	</div>
</body>

</html>