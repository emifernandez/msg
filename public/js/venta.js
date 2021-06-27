var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
$(document).ready(function () {
    getTotal();

    $("#showProducto").on('click', function () {
        limpiarCamposProducto();
        $("#content-productos").toggle(400);
        $(this).find('i').toggleClass('fa-angle-right fa-angle-down')
    });

    $(window).keydown(function (event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });

    $("table").on("click", ".eliminar", function () {
        $(this).parent().parent().remove();
        getTotal();
    });


    $("#addProducto").on("click", function () {
        var val = $('#producto_id').val();
        var cantidad = $('#producto_cantidad').val();
        if (val && cantidad && cantidad > 0) {
            if (verificarDuplicados(val, 'producto')) {
                Swal.fire({
                    text: 'El producto seleccionado ya se encuentra agregado al detalle.',
                    toast: true,
                    icon: 'warning',
                    position: 'top-right',
                    timer: 5000,
                    showConfirmButton: false,
                });
            } else {
                getStock('id', val, true, cantidad);
            }

        } else {
            Swal.fire({
                text: 'Debe introducir un producto y cantidad.',
                toast: true,
                icon: 'warning',
                position: 'top-right',
                timer: 5000,
                showConfirmButton: false,
            });
        }
        limpiarCamposProducto();
    });

    $("table").on("input", ".cantidad", function () {
        const cantidad = $(this).val();
        if (cantidad && cantidad > 0) {
            let cant = Number(cantidad);
            let precio = Number($(this).parent().parent().find('td.precio_unitario select.precio option:selected').text().replaceAll('.', ''));
            const value = $(this).parent().parent().find('td select.precio option:selected').val();
            $(this).parent().parent().find('td input.subtotal').val(formatMiles(cant * precio));

            let iva = value.split('-')[1];
            $(this).parent().parent().find('td input.iva').val(getIva(iva, (cant * precio)));
            getTotal();
        } else {
            Swal.fire({
                text: 'Cantidad no disponible. Verifique su stock o reserva.',
                toast: true,
                icon: 'warning',
                position: 'top-right',
                timer: 5000,
                showConfirmButton: false,
            });
            $(this).val(1);
        }
    });

    $("table").on("change", ".precio_unitario", function () {
        const pu = $(this).find('select.precio option:selected').text();
        const value = $(this).find('select.precio option:selected').val();
        if (pu && value) {
            let precio = Number(pu * 1000);
            let cant = Number($(this).parent().parent().find('td input.cantidad').val());
            $(this).parent().find('td input.subtotal').val(formatMiles(cant * precio));

            let iva = value.split('-')[1];
            $(this).parent().find('td input.iva').val(getIva(iva, (cant * precio)));
            getTotal();
        }
    });

    $("#codigo_barra").blur(function () {
        var val = $('#codigo_barra').val();
        if (val.length >= 1) {
            getStock('codigo_barra', val, false);
        }
    });

    $("#producto_id").on('change', function (event) {
        var val = $('#producto_id').val();
        if (val) {
            getStock('id', val, false);
        } else {
            limpiarCamposProducto();
        }

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

    $("#tipo_comprobante").on('change', function (event) {
        var val = $('#tipo_comprobante').val();
        if (val) {
            $("#content-factura").toggle(400);
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
                                '<td style="display:none;"><input type="text" class="form-control id" name="ids[]" readonly value="' + codigo + '"></td>' +
                                '<td style="display:none;"><input type="text" class="form-control" name="tipo[]" readonly value="reserva"></td>' +
                                '<td class="text-right"><input type="number" class="form-control form-control-sm text-right cantidad" min="1" max="' + cantidad + '" oninput="validity.valid||(value=\'\');" name="cantidad[]" value="' + cantidad + '" /></td>' +
                                '<td class="text-center">' + codigo + '</td>' +
                                '<td>' + descripcion + '</td>' +
                                '<td style="display:none;"><input type="text" class="form-control iva" name="iva[]" value="' + (precios.length > 0 ? getIva(precios[0].iva, (cantidad * precio_unitario)) : 0) + '"></td>' +
                                '<td class="text-right precio_unitario">' + generarSelectPrecio(precios) + '</td>' +
                                '<td class="text-right"><input type="text" disabled class="form-control form-control-sm text-right subtotal" min="1" name="subtotal[]" value="' + formatMiles(cantidad * precio_unitario) + '" /></td>' +
                                '<td class="text-center"><button class="btn btn-danger btn-sm eliminar" data-toggle="tooltip" data-placement="top" title="Eliminar detalle"><i class="fas fa-trash-alt"></i></button></td>' +
                                '</tr>';
                            $('#detalle tbody').append(tr_str);
                        }
                        getTotal();
                    }

                } else {
                    Swal.fire({
                        text: 'El cliente ingresado no existe.',
                        toast: true,
                        icon: 'warning',
                        position: 'top-right',
                        timer: 5000,
                        showConfirmButton: false,
                    });
                    limpiarCamposCliente();
                }
            }
        })
    }

    function getStock(campo, producto, agregar, cantidad = 1) {
        $.ajax({
            url: '/getStock',
            type: 'POST',
            dataType: 'json',
            data: {
                _token: CSRF_TOKEN,
                valor: producto,
                campo: campo
            },
            success: function (response) {
                if (response['stock'].length > 0) {
                    let producto = response['stock'][0];
                    if (agregar) {
                        if (cantidad <= producto.cantidad_actual) {
                            precios = [{ id: producto.producto_id, iva: Number(producto.iva), precio: producto.precio_venta }];
                            var tr_str = '<tr>' +
                                '<td style="display:none;"><input type="text" class="form-control id" name="ids[]" readonly value="' + producto.stock_id + '-' + producto.producto_id + '"></td>' +
                                '<td style="display:none;"><input type="text" class="form-control tipo" name="tipo[]" readonly value="producto"></td>' +
                                '<td class="text-right"><input type="number" min="1" max="' + producto.cantidad_actual + '" oninput="validity.valid||(value=\'\');" class="form-control form-control-sm text-right cantidad" min="1" name="cantidad[]" value="' + cantidad + '" /></td>' +
                                '<td class="text-center">' + producto.codigo_barra + '</td>' +
                                '<td>' + producto.nombre + '</td>' +
                                '<td style="display:none;"><input type="text" class="form-control iva" name="iva[]" value="' + (getIva(Number(producto.iva).toString(), (producto.precio_venta))) + '"></td>' +
                                '<td class="text-right precio_unitario">' + generarSelectPrecio(precios) + '</td>' +
                                '<td class="text-right"><input type="text" readonly class="form-control form-control-sm text-right subtotal" min="1" name="subtotal[]" value="' + formatMiles(producto.precio_venta) + '" /></td>' +
                                '<td class="text-center"><button class="btn btn-danger btn-sm eliminar" data-toggle="tooltip" data-placement="top" title="Eliminar detalle"><i class="fas fa-trash-alt"></i></button></td>' +
                                '</tr>';
                            $('#detalle tbody').append(tr_str);
                            getTotal();
                        } else {
                            Swal.fire({
                                text: 'Sólo existen ' + producto.cantidad_actual + ' en stock',
                                toast: true,
                                icon: 'warning',
                                position: 'top-right',
                                timer: 5000,
                                showConfirmButton: false,
                            });
                        }

                    } else {
                        $('#codigo_barra').val(producto.codigo_barra);
                        $('#producto_cantidad').val('1');
                        if (campo != 'id') {
                            $('#producto_id').val(producto.producto_id);
                            $('#producto_id').trigger('change');

                        }
                    }
                    return producto;
                } else {
                    Swal.fire({
                        text: 'El producto ingresado no existe.',
                        toast: true,
                        icon: 'warning',
                        position: 'top-right',
                        timer: 5000,
                        showConfirmButton: false,
                    });
                    limpiarCamposProducto();
                    return null;
                }
            }
        })
    }

    function limpiarCamposCliente() {
        $('#numero_documento').val(null);
        $('#ruc').val(null);
        $('#cliente_id').val(null);
    }
    function limpiarCamposProducto() {
        $('#codigo_barra').val(null);
        $('#producto_id').val(null);
        $('#producto_cantidad').val(null);
    }
    function limpiarDetalle() {
        $('#detalle tbody').empty();
        $('#total-iva-10').html('Gs. 0');
        $('#total-iva-5').html('Gs. 0');
        $('#total').html('Gs. 0');
    }

    function formatMiles(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function generarSelectPrecio(precios) {
        let select = '<select class="form-control form-control-sm precio" name="precio[]">';
        for (let i = 0; i < precios.length; i++) {
            select += '<option value="' + precios[i].id + '-' + precios[i].iva + '-' + precios[i].precio + '">' + precios[i].precio + '</option>';
        }
        select += '</select>';
        return select;
    }
    function getIva(iva, precio) {
        let valor = 0;
        switch (iva) {
            case '5':
                valor = precio / 22;
                break;
            case '10':
                valor = precio / 11;
                break;
            default:
                valor = precio;
                break;
        }
        return iva + '-' + Math.round(valor);
    }

    function getTotal() {
        var total = 0;
        let iva5 = 0;
        let iva10 = 0;
        let iva0 = 0;
        $("#body tr").each(function () {
            total += Number($(this).find('td input.subtotal').val().replaceAll('.', ''));
            impuesto = $(this).find('td input.iva').val().split('-');
            valor = Number(impuesto[1].replaceAll('.', ''));
            switch (impuesto[0]) {
                case '5':
                    iva5 += valor;
                    break;
                case '10':
                    iva10 += valor;
                    break;
                default:
                    iva0 += valor;
                    break;
            }
        });
        $('#total').val(formatMiles(total));
        $('#total-iva-10').val(formatMiles(iva10));
        $('#total-iva-5').val(formatMiles(iva5));
        $('#total-iva-0').val(formatMiles(iva0));
    }

    function verificarDuplicados(c, t) {
        let found = false;
        $("#body tr").each(function () {
            id = $(this).find('td input.id').val();
            tipo = $(this).find('td input.tipo').val();
            if (c == id && t == tipo) {
                found = true;
            }
        });
        return found;
    }
});
