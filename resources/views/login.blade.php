@extends('layouts.app')

@section('title', 'Inicia sesión en Graffitibook')

@section('content')

    <div class="d-flex justify-content-center mt-5">
        <a class="btn btn-guay" href="{{url('/login/redirect')}}"> <i class="fab fa-google"></i> Inicia sesion con Google </a>
    </div>

@endsection
