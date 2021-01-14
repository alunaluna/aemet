<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('owlcarousel/owl.carousel.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('owlcarousel/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="{{ asset('owlcarousel/owl.carousel.min.js') }}"></script>

	<!-- Dropzone (drop files)-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/min/dropzone.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.js"></script>

	<link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @mapstyles
</head>

<body id="main">

    @section('navbar')
    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top">

        <div class="container d-flex align-items-center">
            <h1 class="logo mr-auto text-light"><a href="{{url('/')}}">Web Graffitis<span></span></a></h1>
			@if(auth()->user())
            <a href="{{url('/new')}}" class="btn btn-guay scrollto">Nuevo Post</a>
            <li class="drop-down" id="perfil"><a href="{{url('/user/'.auth()->user()->id)}}"><img src="{{auth()->user()->foto_perfil}}"/></a>
                <ul>
                    <li><a href="{{url('/user/'.auth()->user()->id)}}">Mi perfil</a></li>
                    <li><a href="#" id="cerrar-sesion">Cerrar sesión</a></li>
                </ul>
            </li>
			@else
			<a href="{{url('/login')}}" class="btn btn-guay scrollto">Iniciar sesión</a>
			@endif
        </div>

    </header><!-- .nav-menu -->
    @show


    <div class="container pt-5 mt-5">
        @yield('content')

    </div>

    @section('footer')
		<footer class="footer mt-5">
			<div class="container">
				<span>Graffiti web © 2021</span>
			</div>
		</footer>
    @show

</body>

@mapscripts

@yield('my_scripts')

<script>
    $(document).ready(function() {
        $(".owl-carousel").owlCarousel();
    });

    $('.owl-carousel').owlCarousel({
        loop: true
        , margin: 10
        , nav: true
        , responsive: {
            0: {
                items: 1
            }
            , 600: {
                items: 3
            }
        }
    })

</script>

</html>
