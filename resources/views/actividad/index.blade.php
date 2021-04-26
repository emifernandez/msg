@extends('adminlte::page')
@section('title', 'Actividades')

@section('content_header')
    <h1>Actividades</h1>
@stop

@section('content')
<div class="col-sm-12">
  </div>
<div class="panel panel-default">
    <div style="margin: 10px;" class="panel-heading">
        @can('create', $aux)
        <a  href="{{route('actividad.create')}}" class="btn btn-primary">Nueva Actividad</a>
        @endcan
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table width="100%" class="table table-striped table-bordered table-hover" id="tabla">
                <thead>
                    <tr>
                        <th>Actividad</th>
                        <th>Servicio</th>
                        <th>Empleado</th>
                        <th>Salón</th>
                        <th>Días</th>
                        <th>Horario</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($actividades as $key => $actividad)
                    <tr>
                        <td>{{ $actividad->nombre }}</td>
                        <td>{{ $actividad->servicio->descripcion }}</td>
                        <td>{{ $actividad->empleado->nombre . ' ' .  $actividad->empleado->apellido}}</td>
                        <td>{{ $actividad->salon->nombre }}</td>
                        <td>
                            <span @if($actividad->dias[0] == '1') class="badge badge-success" @else class="badge" @endif>D </span>
                            <span @if($actividad->dias[1] == '1') class="badge badge-success" @else class="badge" @endif>L </span>
                            <span @if($actividad->dias[2] == '1') class="badge badge-success" @else class="badge" @endif>M </span>
                            <span @if($actividad->dias[3] == '1') class="badge badge-success" @else class="badge" @endif>M </span>
                            <span @if($actividad->dias[4] == '1') class="badge badge-success" @else class="badge" @endif>J </span>
                            <span @if($actividad->dias[5] == '1') class="badge badge-success" @else class="badge" @endif>V </span>
                            <span @if($actividad->dias[6] == '1') class="badge badge-success" @else class="badge" @endif>S </span>
                        </td>
                        <td>{{ $actividad->hora_inicio->forFormHour() . ' a ' . $actividad->hora_fin->forFormHour() }}</td>
                        <td>{{ $estados[$actividad->estado] }}</td>
                        <td style="display: block;  margin: auto;">
                            @can('delete', $actividad)
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-danger" data-data="{{$actividad->id}}">
                                <i class="fas fa-trash-alt" aria-hidden="true"></i>
                            </button>
                            @endcan
                            @can('update', $actividad)
                            <a href="{{ route('actividad.edit', $actividad->id) }}" class= "btn btn-info"><i class="fas fa-pencil-alt"></i></a>
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
          <h4 class="modal-title">Eliminar Actividad</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('actividad.destroy', 'test')}}" method="post">
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