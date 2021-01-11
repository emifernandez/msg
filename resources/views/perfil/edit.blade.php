@extends('adminlte::page')
@section('title', 'Perfiles')

@section('content')
<div class="row">
	<div class="col-lg-12">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Editar Perfil</h3>
                            </div>
                            <form role="form" id="form" method="POST" action="{{ route('perfil.update', $perfil->id) }}">
                                @method('PATCH')
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="perfil">Perfil</label>
                                        <input class="form-control"
                                            type="text"
                                            name="perfil"
                                            id="perfil"
                                            value="{{ old('perfil', $perfil->perfil) }}"
                                            placeholder="Introduzca nombre del perfil">
                                            @foreach ($errors->get('perfil') as $error)
                                                <span class="text text-danger">{{ $error }}</span>
                                            @endforeach
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Grabar</button>
                                    <a href="{{ route('perfil.index') }}" class="btn btn-secondary btn-close">Cancelar</a>
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