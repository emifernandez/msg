@extends('adminlte::page')
@section('title', 'Productos')

@section('content_header')
    <h1>Productos</h1>
@stop

@section('content')
<div class="col-sm-12">
  </div>
<div class="panel panel-default">
    <div style="margin: 10px;" class="panel-heading">
        @can('create', $aux)
        <a  href="{{route('producto.create')}}" class="btn btn-primary">Nuevo Producto</a>
        @endcan
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table width="100%" class="table table-striped table-bordered table-hover" id="tabla">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Codigo</th>
                        <th>Marca</th>
                        <th>Tipo</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productos as $key => $producto)
                    <tr>
                        <td>{{ $producto->nombre }}</td>
                        <td>{{ $producto->codigo_barra }}</td>
                        <td>{{ $producto->marca->nombre }}</td>
                        <td>{{ $tipos[$producto->tipo]}}</td>
                        <td>{{ $estados[$producto->estado] }}</td>
                        <td style="display: block;  margin: auto;">
                            @can('delete', $producto)
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-danger" data-data="{{$producto->id}}">
                                <i class="fas fa-trash-alt" aria-hidden="true"></i>
                            </button>
                            @endcan
                            @can('update', $producto)
                            <a href="{{ route('producto.edit', $producto->id) }}" class= "btn btn-info"><i class="fas fa-pencil-alt"></i></a>
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
          <h4 class="modal-title">Eliminar Producto</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('producto.destroy', 'test')}}" method="post">
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