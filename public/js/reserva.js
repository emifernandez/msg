var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
$(document).ready(function () {
    $("#btn_buscar").click(function () {
        const a_data = $('#actividad_id').val().split('|');
        const actividad_id = parseInt(a_data[0]);
        const fi = $('#fecha_inicio').val().split('-');
        const fecha_inicio = fi[2] + '-' + fi[1] + '-' + fi[0];
        const ff = $('#fecha_fin').val().split('-');
        const fecha_fin = ff[2] + '-' + ff[1] + '-' + ff[0];
        const cliente_id = $('#cliente_id').val();
        if ($('#fecha_inicio').val() && $('#fecha_fin').val() && $('#actividad_id').val()) {
            if (cliente_id) {
                getEventos(fecha_inicio, fecha_fin, actividad_id, cliente_id);
            } else {
                Swal.fire({
                    text: 'Debe seleccionar un cliente',
                    toast: true,
                    icon: 'warning',
                    position: 'top-right',
                    timer: 5000,
                    showConfirmButton: false,
                });
            }

        }
    });

    $('#select-evento').change(function () {
        if ($(this).is(':checked')) {
            seleccionar(true);
        } else {
            seleccionar(false);
        }
    });

    function seleccionar(valor) {
        $("#body tr").each(function () {
            $(this).find('td input.item').attr("checked", valor);
        });
    }

    function getEventos(fecha_inicio, fecha_fin, actividad_id, cliente_id) {
        $.ajax({
            url: '/getEventos',
            type: 'POST',
            dataType: 'json',
            data: {
                _token: CSRF_TOKEN,
                fecha_inicio: fecha_inicio,
                fecha_fin: fecha_fin,
                actividad_id: actividad_id,
                cliente_id: cliente_id
            },
            success: function (response) {
                var len = 0;
                if (response['data'] != null) {
                    len = response['data'].length;
                }
                $('#tabla-reserva tbody').empty();
                if (len > 0) {
                    var texto = $('#actividad_id :selected').text();;
                    var hora = texto.substring(0, 11);
                    var actividad = texto.replace(hora, '');
                    for (var i = 0; i < len; i++) {
                        var id = response['data'][i].id;
                        var fecha = response['data'][i].fecha;
                        var tr_str = '<tr>' +
                            '<td style="width: 2%"><input type="checkbox" class="item" id="eventos[]" name="eventos[]" value=' + id + '></td>' +
                            '<td style="width: 15%" align="center">' + fecha + '</td>' +
                            '<td style="width: 15%" align="center">' + hora + '</td>' +
                            '<td>' + actividad + '</td>' +
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
    var container = $('.container-fluid form').length > 0 ? $('.container-fluid form').parent() : "body";
    $("#actividad_id").on('change', function (event) {
        $('#fecha_inicio').val('');
        $('#fecha_fin').val('');
        $('#tabla-reserva tbody').empty();
        if (this.value.length > 0) {
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
            if (ff.length == 3) {
                const fecha_fin = new Date(ff[2] + '/' + ff[1] + '/' + ff[0]);
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
