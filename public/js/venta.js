var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
$(document).ready(function () {
    $(window).keydown(function (event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });

    function formatMiles(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    $("table").on("click", ".eliminar", function () {
        $(this).parent().parent().remove();
    });

    var tipo = $('#numero_documento').val();
    $("#numero_documento").blur(function () {
        var val = $('#numero_documento').val();
        if (val.length >= 5) {
            getCliente('numero_documento', val);
        }
    });
    $("#ruc").blur(function () {
        var val = $('#ruc').val();
        if (val.length >= 5) {
            getCliente('ruc', val);
        }
    });

    $("#cliente_id").on('change', function (event) {
        var val = $('#cliente_id').val();
        if (val) {
            getCliente('id', val);
        } else {
            limpiarCamposCliente();
        }

    });

    function getCliente(campo, valor) {
        $.ajax({
            url: '/getCliente',
            type: 'POST',
            dataType: 'json',
            data: {
                _token: CSRF_TOKEN,
                campo: campo,
                valor: valor
            },
            success: function (response) {
                if (response['cliente'].length > 0) {
                    let cliente = response['cliente'][0];
                    $('#numero_documento').val(cliente.numero_documento);
                    $('#ruc').val(cliente.ruc);
                    if (campo != 'id') {
                        $('#cliente_id').val(cliente.id);
                        $('#cliente_id').trigger('change');
                    }
                    limpiarDetalle();
                    if (response['reservas'].length > 0) {
                        for (var i = 0; i < response['reservas'].length; i++) {
                            var precios = response['reservas'][i].precios;

                            var cantidad = Number(response['reservas'][i].cantidad);
                            var codigo = response['reservas'][i].codigo;
                            var descripcion = response['reservas'][i].descripcion;
                            var precio_unitario = Number(response['reservas'][i].precio_unitario);
                            var tr_str = '<tr>' +
                                '<td style="display:none;"><input type="text" class="form-control item" name="ids[]" readonly value="' + codigo + '"></td>' +
                                '<td style="display:none;"><input type="text" class="form-control item" name="tipo[]" readonly value="reserva"></td>' +
                                '<td class="text-right"><input type="number" class="form-control form-control-sm text-right" min="1" name="cantidad[]" value="' + cantidad + '" /></td>' +
                                '<td class="text-center">' + codigo + '</td>' +
                                '<td>' + descripcion + '</td>' +
                                '<td class="text-right">' + generarSelectPrecio(precios) + '</td>' +
                                '<td class="text-right"><input type="number" disabled class="form-control form-control-sm text-right" min="1" name="precio_unitario[]" value="' + formatMiles(cantidad * precio_unitario) + '" /></td>' +
                                '<td class="text-center"><button class="btn btn-danger btn-sm eliminar" data-toggle="tooltip" data-placement="top" title="Eliminar detalle"><i class="fas fa-trash-alt"></i></button></td>' +
                                '</tr>';
                            $('#detalle tbody').append(tr_str);
                        }
                    }

                } else {
                    Swal.fire({
                        text: 'El cliente ingresado no existe ',
                        toast: true,
                        icon: 'warning',
                        position: 'top-right',
                        timer: 3000,
                        showConfirmButton: false,
                    });
                    limpiarCamposCliente();
                }
            }
        })
    }

    function limpiarCamposCliente() {
        $('#numero_documento').val(null);
        $('#ruc').val(null);
        $('#cliente_id').val(null);
    }
    function limpiarDetalle() {
        $('#detalle tbody').empty();
        $('#total-iva-10').html('Gs. 0');
        $('#total-iva-5').html('Gs. 0');
        $('#total').html('Gs. 0');
    }

    function generarSelectPrecio(precios) {
        let select = '<select class="form-control form-control-sm">';
        for (let i = 0; i < precios.length; i++) {
            select += '<option value="' + precios[i] + '">' + precios[i].precio + '</option>';
        }
        select += '</select>';
        return select;
    }
});
