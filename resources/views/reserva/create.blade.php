@extends('adminlte::page')
@section('title', 'Reservas')
@section('meta_tags')
<meta name="csrf-token" content="{{ csrf_token() }}"
@endsection
@section('content')
<div class="row">
	<div class="col-lg-12">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Crear Reserva</h3>
                            </div>
                            <form role="form" id="form" method="POST" action="{{ route('reserva.store') }}" autocomplete="off">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Cliente</label>
                                        <select class="form-control select" style="width: 100%" name="cliente_id" id="cliente_id">
                                            <option value="">Seleccione un Cliente</option>
                                            @foreach($clientes as $key => $cliente)
                                                <option value="{{ $cliente->id }}"
                                                    @if($cliente->id == old('cliente_id')) selected @endif
                                                    >{{ $cliente->nombre . ' ' . $cliente->apellido }}</option>
                                            @endforeach
                                        </select>
                                        @foreach ($errors->get('cliente_id') as $error)
                                            <span class="text text-danger">{{ $error }}</span>
                                        @endforeach
                                    </div>
                                    <div class="form-group">
                                        <label>Actividad</label>
                                        <select class="form-control select" style="width: 100%" name="actividad_id" id="actividad_id">
                                            <option value="">Seleccione una Actividad</option>
                                            @foreach($actividades as $key => $actividad)
                                                <option value="{{ $actividad->id . '|' .$actividad->fecha_fin->forForm() }}"
                                                    @if($actividad->id == old('actividad_id')) selected @endif
                                                    >{{ $actividad->hora_inicio->forFormHour() . '-' . $actividad->hora_fin->forFormHour() . ' ' .$actividad->nombre}}</option>
                                            @endforeach
                                        </select>
                                        @foreach ($errors->get('actividad_id') as $error)
                                            <span class="text text-danger">{{ $error }}</span>
                                        @endforeach
                                    </div>
                                    <div class="row align-items-end">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="fecha_inicio">Fecha Desde</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control"
                                                    onkeydown="return false"
                                                    name="fecha_inicio"
                                                    id="fecha_inicio"
                                                    value="{{ old('fecha_inicio') }}">
                                                </div>
                                                @foreach ($errors->get('fecha_inicio') as $error)
                                                    <span class="text text-danger">{{ $error }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="fecha_fin">Fecha Hasta</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control"
                                                    onkeydown="return false"
                                                    name="fecha_fin"
                                                    id="fecha_fin"
                                                    value="{{ old('fecha_fin') }}">
                                                </div>
                                                @foreach ($errors->get('fecha_fin') as $error)
                                                    <span class="text text-danger">{{ $error }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <button type="button" class="btn btn-primary" id="btn_buscar" disabled><i class="fas fa-search" aria-hidden="true"></i>
                                                 Buscar Eventos</button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <hr>
                                        <div class="form-group text-center">
                                            <h4>Eventos Disponibles</h4>
                                        </div>
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table width="100%" class="table table-striped table-bordered table-hover" id="tabla-reserva">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 2%"></th>
                                                            <th style="width: 15%">Fecha</th>
                                                            <th style="width: 15%">Horario</th>
                                                            <th>Actividad</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody> </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Grabar</button>
                                    <a href="{{ route('reserva.index') }}" class="btn btn-secondary btn-close">Cancelar</a>
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
@section('js')
<script type="text/javascript">
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function () {
        $("#btn_buscar").click(function(){
            const a_data = $('#actividad_id').val().split('|');
            const actividad_id = parseInt(a_data[0]);
            const fi = $('#fecha_inicio').val().split('-');
            const fecha_inicio = fi[2]+'-'+fi[1]+'-'+fi[0];
            const ff = $('#fecha_fin').val().split('-');
            const fecha_fin = ff[2]+'-'+ff[1]+'-'+ff[0];
            if($('#fecha_inicio').val() && $('#fecha_fin').val() && $('#actividad_id').val()) {
                getEventos(fecha_inicio, fecha_fin, actividad_id);
            } 
        })

        function getEventos(fecha_inicio, fecha_fin, actividad_id) {
            $.ajax({
                url:'{{route("getEventos")}}',
                type:'POST',
                dataType: 'json',
                data: {
                    _token: CSRF_TOKEN,
                    fecha_inicio: fecha_inicio,
                    fecha_fin: fecha_fin,
                    actividad_id: actividad_id
                },
                success: function(response) {
                    var len = 0;
                    if(response['data'] != null) {
                        len = response['data'].length;
                    }
                    $('#tabla-reserva tbody').empty();
                    if(len > 0) {
                        var texto = $('#actividad_id :selected').text();;
                        var hora = texto.substring(0,11);
                        var actividad = texto.replace(hora, '');
                        for(var i=0;i<len; i++) {
                            var id= response['data'][i].id;
                            var fecha= response['data'][i].fecha;
                            var tr_str = '<tr>' +
                                '<td style="width: 2%"><input type="checkbox" id="eventos[]" name="eventos[]" value='+id+'></td>' +
                                '<td style="width: 15%" align="center">'+fecha+'</td>' +
                                '<td style="width: 15%" align="center">'+hora+'</td>' +
                                '<td>'+actividad+'</td>' +
                                '</tr>';
                            $('#tabla-reserva tbody').append(tr_str);
                        }

                    } else {
                        var tr_str = ' <tr> <td align="center" colspan="4">No se encontraron eventos disponibles</td> </tr>';
                        $('#tabla-reserva tbody').append(tr_str);
                    }
                }
            })
        }
        var container=$('.container-fluid form').length>0 ? $('.container-fluid form').parent() : "body";
        $("#actividad_id").on('change', function(event) {
            $('#fecha_inicio').val('');
            $('#fecha_fin').val('');
            $('#tabla-reserva tbody').empty();
            if(this.value.length > 0) {
                const data = this.value.split('|');
                const actividad_id = parseInt(data[0]);
                var startDate = new Date();
                startDate.setDate(startDate.getDate() + 1);
                
                $('#fecha_inicio').datepicker({
                    format: 'dd-mm-yyyy',
                    orientation: "bottom left",
                    autoclose: true,
                    startDate: startDate,
                    container: container,
                    clearBtn: true,
                    language: 'es'
                });
                $('#fecha_fin').datepicker({
                    format: 'dd-mm-yyyy',
                    orientation: "bottom left",
                    autoclose: true,
                    startDate: startDate,
                    container: container,
                    clearBtn: true,
                    language: 'es'
                });
                ff = data[1].split('-');
                if(ff.length == 3) {
                    const fecha_fin = new Date(ff[2]+'/'+ff[1]+'/'+ff[0]);
                    $('#fecha_inicio').datepicker('setEndDate', fecha_fin);
                    $('#fecha_fin').datepicker('setEndDate', fecha_fin);
                } else {
                    $('#fecha_inicio').datepicker('setEndDate', null);
                    $('#fecha_fin').datepicker('setEndDate', null);
                }
                $('#fecha_inicio').removeAttr('disabled');
                $('#fecha_fin').removeAttr('disabled');
                $('#btn_buscar').removeAttr('disabled');
            } else {
                $('#fecha_inicio').attr('disabled', true);
                $('#fecha_fin').attr('disabled', true);
                $('#btn_buscar').attr('disabled', true);
            }
        });
        $('#btn_buscar').attr('disabled', true);
        $('#fecha_inicio').attr('disabled', true);
        $('#fecha_fin').attr('disabled', true);
    });
</script>
@endsection