@extends('adminlte::page')
@section('title', 'Tipos de Crédito')

@section('content_header')
    <h1>Tipos de Crédito</h1>
@stop

@section('content')
<div class="col-sm-12">
  </div>
<div class="panel panel-default">
    <div style="margin: 10px;" class="panel-heading">
        @can('create', $aux)
        <a  href="{{route('tipo-credito.create')}}" class="btn btn-primary">Nuevo Tipo de Crédito</a>
        @endcan
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table width="100%" class="table table-striped table-bordered table-hover" id="tabla">
                <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>% Tasa Diaria</th>
                        <th>% Tasa</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tipos as $key => $tipo)
                    <tr>
                        <td>{{ $tipo->descripcion }}</td>
                        <td>{{ $tipo->tasa_diaria }}</td>
                        <td>{{ $tipo->tasa }}</td>
                        <td style="display: block;  margin: auto;">
                            @can('delete', $tipo)
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-danger" data-data="{{$tipo->id}}">
                                <i class="fas fa-trash-alt" aria-hidden="true"></i>
                            </button>
                            @endcan
                            @can('update', $tipo)
                            <a href="{{ route('tipo-credito.edit', $tipo->id) }}" class= "btn btn-info"><i class="fas fa-pencil-alt"></i></a>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-danger">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-danger">
          <h4 class="modal-title">Eliminar Tipo de Crédito</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('tipo-credito.destroy', 'test')}}" method="post">
            @csrf
            @method('DELETE')
            <div class="modal-body">
            <p>¿Esta seguro que desea eliminar el registro?</p>
            <input type="hidden" id="id" name="id" value="">
            </div>
            <div class="modal-footer justify-content-between">
                <button class="btn btn-danger" type="submit"><i class="fas fa-trash-alt" aria-hidden="true"></i> Eliminar</button>
            </div>
        </form>
      </div>
    </div>
</div>
@stop

@section('js')
<script>
    $('#modal-danger').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var data = button.data('data') // Extract info from data-* attributes
        var modal = $(this)
        modal.find('.modal-body #id').val(data)
        })
</script>
@stop