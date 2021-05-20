@extends('adminlte::page')
@section('title', 'Reservas')

@section('content_header')
    <h1>Reservas</h1>
@stop

@section('content')
<div class="col-sm-12">
  </div>
<div class="panel panel-default">
    <div style="margin: 10px;" class="panel-heading">
        @can('create', $aux)
        <a  href="{{route('reserva.create')}}" class="btn btn-primary">Nueva Reserva</a>
        @endcan
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table width="100%" class="table table-striped table-bordered table-hover" id="tabla">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Evento</th>
                        <th>Fecha</th>
                        <th>Horario</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservas as $key => $reserva)
                    <tr>
                        <td>{{ $reserva->cliente->nombre . ' ' . $reserva->cliente->apellido }}</td>
                        <td>{{ $reserva->evento->actividad->nombre }}</td>
                        <td>{{ $reserva->evento->fecha }}</td>
                        <td>{{ $reserva->evento->actividad->hora_inicio->forFormHour() . ' - ' .  $reserva->evento->actividad->hora_fin->forFormHour()}}</td>
                        <td>{{ $estados[$reserva->estado] }}</td>
                        <td style="display: block;  margin: auto;">
                            @can('delete', $reserva)
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-danger" data-data="{{$reserva->id}}"
                                @if($reserva->estado <> '1')
                                    disabled
                                @endif>
                                <i class="fas fa-ban" aria-hidden="true"></i> Cancelar
                            </button>
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
          <h4 class="modal-title">Cancelar Reserva</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('reserva.destroy', 'test')}}" method="post">
            @csrf
            @method('DELETE')
            <div class="modal-body">
            <p>¿Esta seguro que desea cancelar la reserva?</p>
            <input type="hidden" id="id" name="id" value="">
            </div>
            <div class="modal-footer justify-content-between">
                <button class="btn btn-danger" type="submit"><i class="fas fa-trash-alt" aria-hidden="true"></i> Cancelar</button>
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