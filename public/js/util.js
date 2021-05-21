$(document).ready(function () {
    $('.tabla-simple').DataTable({
        responsive: true,
    });
    $('.addAcceso').on('click', function () {
        addAcceso();
    })
    $('.addServicio').on('click', function () {
        addServicio();
    })
    $("table").on("click", ".eliminar", function () {
        $(this).parent().parent().remove();
    });

    function addAcceso() {
        var duplicado = false;
        var a = document.getElementById("acceso");
        var crear = document.getElementById("crear");
        var eliminar = document.getElementById("eliminar");
        var modificar = document.getElementById("modificar");
        var visualizar = document.getElementById("visualizar");
        var imprimir = document.getElementById("imprimir");
        var anular = document.getElementById("anular");
        var acceso = JSON.parse(a.value);
        var table = document.getElementById("tabla-acceso");
        var row = table.insertRow(-1);
        $("tr").each(function () {
            $this = $(this);
            var valor = $this.find("input.item").val();
            if (valor == acceso.id) {
                duplicado = true;
                Swal.fire({
                    text: 'El permiso no puede asignarse ',
                    toast: true,
                    icon: 'error',
                    position: 'top-right'
                });
            }
        });
        if (!duplicado) {
            row.innerHTML = '<td style="display:none;"><input type="text" class="form-control item" name="acceso[]" readonly value="' + acceso.id + '"></td>'
                + '<td><input type="text" class="form-control" name="acceso_descripcion[]" readonly value="' + acceso.descripcion + '"></td>'
                + '<td class="text-center" valign="center"> <input class="form-check-input" type="checkbox" name="crear[]" value="' + acceso.id + '"> </td>'
                + '<td class="text-center" valign="center"> <input class="form-check-input" type="checkbox" name="modificar[]" value="' + acceso.id + '"> </td>'
                + '<td class="text-center" valign="center"> <input class="form-check-input" type="checkbox" name="eliminar[]" value="' + acceso.id + '"> </td>'
                + '<td class="text-center" valign="center"> <input class="form-check-input" type="checkbox" name="visualizar[]" value="' + acceso.id + '"> </td>'
                + '<td class="text-center" valign="center"> <input class="form-check-input" type="checkbox" name="imprimir[]" value="' + acceso.id + '"> </td>'
                + '<td class="text-center" valign="center"> <input class="form-check-input" type="checkbox" name="anular[]" value="' + acceso.id + '"> </td>'
                + '<td><a class="btn btn-danger eliminar" data-toggle="tooltip" title="Eliminar Acceso"><i class="fas fa-trash-alt"></i></a></td>';
            a.value = null;
        }
    }

    if ($("#cantidad").length) {
        new AutoNumeric('#cantidad', {
            digitGroupSeparator: '.',
            decimalCharacter: ',',
            decimalPlaces: '0',
            minimumValue: '1',
            overrideMinMaxLimits: 'invalid',
            unformatOnSubmit: true
        });
    }

    if ($("#precio_compra").length) {
        new AutoNumeric('#precio_compra', {
            digitGroupSeparator: '.',
            decimalCharacter: ',',
            decimalPlaces: '0',
            minimumValue: '1',
            overrideMinMaxLimits: 'invalid',
            unformatOnSubmit: true
        });
    }

    if ($("#precio_venta").length) {
        new AutoNumeric('#precio_venta', {
            digitGroupSeparator: '.',
            decimalCharacter: ',',
            decimalPlaces: '0',
            minimumValue: '1',
            overrideMinMaxLimits: 'invalid',
            unformatOnSubmit: true
        });
    }

    if ($("#cantidad_actual").length) {
        new AutoNumeric('#cantidad_actual', {
            digitGroupSeparator: '.',
            decimalCharacter: ',',
            decimalPlaces: '2',
            overrideMinMaxLimits: 'invalid',
            unformatOnSubmit: true
        });
    }

    if ($("#cantidad_minima").length) {
        new AutoNumeric('#cantidad_minima', {
            digitGroupSeparator: '.',
            decimalCharacter: ',',
            decimalPlaces: '2',
            overrideMinMaxLimits: 'invalid',
            unformatOnSubmit: true
        });
    }

    if ($("#cantidad_maxima").length) {
        new AutoNumeric('#cantidad_maxima', {
            digitGroupSeparator: '.',
            decimalCharacter: ',',
            decimalPlaces: '2',
            overrideMinMaxLimits: 'invalid',
            unformatOnSubmit: true
        });
    }

    if ($("#precio").length) {
        new AutoNumeric('#precio', {
            digitGroupSeparator: '.',
            decimalCharacter: ',',
            decimalPlaces: '0',
            minimumValue: '1',
            overrideMinMaxLimits: 'invalid',
            unformatOnSubmit: true
        });
    }
    function addServicio() {
        var duplicado = false;
        var cantidad = document.getElementById("cantidad");
        var precio = document.getElementById("precio");
        var iva = document.getElementById("iva");
        var table = document.getElementById("tabla-servicio");
        var row = table.insertRow(-1);
        $("tr").each(function () {
            $this = $(this);
            var valor = $this.find("input.item").val();
            if (valor == cantidad.value) {
                duplicado = true;
                Swal.fire({
                    text: 'Ya existe un detalle con la cantidad asignada ',
                    toast: true,
                    icon: 'error',
                    position: 'top-right'
                });
            }
        });
        if (cantidad.value < 1 || precio.value < 1) {
            Swal.fire({
                text: 'El precio y la cantidad deben ser mayores a 0',
                toast: true,
                icon: 'error',
                position: 'top-right'
            });
        } else {
            if (!duplicado && cantidad.value && precio.value && iva.value) {
                row.innerHTML = '<td><input type="text" class="form-control item" name="cantidades[]" readonly value="' + cantidad.value + '"></td>'
                    + '<td><input type="text" class="form-control" name="precios[]" readonly value="' + precio.value + '"></td>'
                    + '<td><input type="text" class="form-control" name="ivas[]" readonly value="' + iva.value + '"></td>'
                    + '<td><a class="btn btn-danger eliminar" data-toggle="tooltip" title="Eliminar detalle"><i class="fas fa-trash-alt"></i></a></td>';
                cantidad.value = null;
                precio.value = null;
                iva.value = null;
            }
        }
    }
});