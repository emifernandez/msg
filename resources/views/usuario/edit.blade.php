@extends('adminlte::page')
@section('title', 'Usuarios')

@section('content')
<div class="row">
	<div class="col-lg-12">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Editar Usuario</h3>
                            </div>
                            <form role="form" id="form" method="POST" action="{{ route('usuario.update', $usuario->id) }}">
                                @method('PATCH')
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="name">Nombre</label>
                                        <input class="form-control"
                                            type="text"
                                            name="name"
                                            id="name"
                                            value="{{ old('name', $usuario->name) }}"
                                            placeholder="Introduzca nombre del usuario">
                                            @foreach ($errors->get('name') as $error)
                                                <span class="text text-danger">{{ $error }}</span>
                                            @endforeach
                                    </div>
                                    <div class="form-group">
                                        <label for="lastname">Apellido</label>
                                        <input class="form-control"
                                            type="text"
                                            name="lastname"
                                            id="lastname"
                                            value="{{ old('lastname', $usuario->lastname) }}"
                                            placeholder="Introduzca apellido del usuario">
                                            @foreach ($errors->get('lastname') as $error)
                                                <span class="text text-danger">{{ $error }}</span>
                                            @endforeach
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input class="form-control"
                                            type="text"
                                            name="email"
                                            id="email"
                                            value="{{ old('email', $usuario->email) }}"
                                            placeholder="Introduzca email del usuario">
                                            @foreach ($errors->get('email') as $error)
                                                <span class="text text-danger">{{ $error }}</span>
                                            @endforeach
                                    </div>
                                    <div class="form-group">
                                        <label>Rol</label>
                                        <select class="form-control" name="rol" id="rol">
                                            <option value="">Seleccione un rol</option>
                                            @foreach($roles as $key => $rol)
                                                <option value="{{ $rol->id }}"
                                                    @if($rol->id == old('rol', $usuario->roles()->first()->id)) selected @endif
                                                    >{{ $rol->nombre }}</option>
                                            @endforeach
                                        </select>
                                        @foreach ($errors->get('rol') as $error)
                                            <span class="text text-danger">{{ $error }}</span>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Grabar</button>
                                    <a href="{{ route('usuario.index') }}" class="btn btn-secondary btn-close">Cancelar</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
	</div>
</div>
@stop