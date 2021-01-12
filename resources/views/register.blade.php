@extends('layouts.app')

@section('title', 'Inicia sesión en Graffitibook')

@section('content')
    <form class="form mt-4" action="{{url('/login')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
			<input type="hidden" value="{{ $usuario->id }}" name="id">
            <div class="form-group col-6">
                <label class="label">Nombre de usuario *</label>
                <input type="text" class="form-control" name="username" placeholder="Nombre que verán los usuarios" required>
            </div>
            <div class="form-group col-3">
                <label class="label">Nombre</label>
                <input type="text" class="form-control" value="{{ $usuario->nombre }}" name="nombre">
            </div>

            <div class="form-group col-3">
                <label class="label">Apellido</label>
                <input type="text" class="form-control" name="apellido">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-12">
                <label class="label">Foto de perfil *</label>
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
            <div class="form-group col-12 text-right">
                <button type="submit" class="btn btn-guay" style="margin-top:2rem">Crear cuenta</button>
            </div>
        </div>
    </form>

@endsection
