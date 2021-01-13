@extends('layouts.app')

@section('title', 'Nuevo graffiti - Web graffitis')

@section('content')

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
		<form class="form mt-4" action="{{url('/new')}}" method="post" enctype="multipart/form-data">
			@csrf
            <div class="row">
                <div class="form-group col-6">
                    <label class="label">Título *</label>
                    <input type="text" class="form-control" name="titulo" required>
                </div>
                <div class="form-group col-6">
                    <label class="label">Autor</label>
                    <input type="text" class="form-control" name="autor">
                </div>
            </div>

			<div class="row">
                <div class="form-group col-12">
                    <label class="label">Imagen *</label>
                    <input type="file" class="form-control-file" name="image" id="image" required>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-12">
                    <label class="label">Descripción</label>
                    <textarea class="form-control" name="descripcion" rows="5"></textarea>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-10">
                    <label class="label">Ubicación</label>
                    <input type="text" class="form-control" name="lugar" id="lugar">
                </div>

                <div class="form-group col-2">
                    <label class="label"></label>
                    <div class="form-control btn btn-guay mt-2 check-sitio" id="check_sitio">Ver sitio</div>
                </div>
            </div>

            <div class="container mb-3">
                @map([
                'lat' => '36.7213028',
                'lng' => '-4.4216366',
                'zoom' => 30,
                ])
            </div>

            <div class="row">
                <div class="form-group col-2">
                    <input type="hidden" class="form-control" name="latitud" id="latitud">
                </div>
                <div class="form-group col-2">
                    <input type="hidden" class="form-control" name="longitud" id="longitud">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-4">
                    <button type="submit" class="btn btn-guay" style="margin-top:2rem">Crear graffiti</button>
                </div>
            </div>
		</form>

@endsection

@section('my_scripts')
    <script src="{{ asset('js/new_post.js') }}"></script>
@endsection
