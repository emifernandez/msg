@extends('adminlte::page')
@section('title', 'Ficha Cliente')

@section('content')
<div class="row">
	<div class="col-lg-12">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Editar Ficha Cliente</h3>
                            </div>
                            <form role="form" id="form" method="POST" action="{{ route('ficha.update', $ficha->id) }}">
                                @method('PATCH')
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <div class="form-group">
                                                <label>Cliente</label>
                                                <select class="form-control" name="cliente_id" id="cliente_id">
                                                    <option value="">Seleccione una cliente</option>
                                                    @foreach($clientes as $key => $cliente)
                                                        <option value="{{ $cliente->id }}"
                                                            @if($cliente->id == old('cliente_id', $ficha->cliente_id)) selected @endif
                                                            >{{ $cliente->nombre . ' ' . $cliente->apellido}}</option>
                                                    @endforeach
                                                </select>
                                                @foreach ($errors->get('cliente_id') as $error)
                                                    <span class="text text-danger">{{ $error }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="altura">Altura (cm)</label>
                                                <input class="form-control"
                                                    type="text"
                                                    name="altura"
                                                    id="altura"
                                                    value="{{ old('altura', $ficha->altura) }}"
                                                    placeholder="Introduzca altura">
                                                    @foreach ($errors->get('altura') as $error)
                                                        <span class="text text-danger">{{ $error }}</span>
                                                    @endforeach
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="peso">Peso (Kg)</label>
                                                <input class="form-control"
                                                    type="text"
                                                    name="peso"
                                                    id="peso"
                                                    value="{{ old('peso', $ficha->peso) }}"
                                                    placeholder="Introduzca peso">
                                                    @foreach ($errors->get('peso') as $error)
                                                        <span class="text text-danger">{{ $error }}</span>
                                                    @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="alergia">Alergias</label>
                                        <textarea class="form-control"
                                            rows="3"
                                            type="text"
                                            name="alergia"
                                            id="alergia"
                                            value="{{ old('alergia', $ficha->alergia) }}"
                                            placeholder="Introduzca alergias">{{ old('alergia') }}</textarea>
                                            @foreach ($errors->get('alergia') as $error)
                                                <span class="text text-danger">{{ $error }}</span>
                                            @endforeach
                                    </div>
                                    <div class="form-group">
                                        <label for="antecedente_medico">Antecedente Médico</label>
                                        <textarea class="form-control"
                                            rows="3"
                                            type="text"
                                            name="antecedente_medico"
                                            id="antecedente_medico"
                                            value="{{ old('antecedente_medico', $ficha->antecedente_medico) }}"
                                            placeholder="Introduzca antecedente médico">{{ old('antecedente_medico') }}</textarea>
                                            @foreach ($errors->get('antecedente_medico') as $error)
                                                <span class="text text-danger">{{ $error }}</span>
                                            @endforeach
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Grabar</button>
                                    <a href="{{ route('ficha.index') }}" class="btn btn-secondary btn-close">Cancelar</a>
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