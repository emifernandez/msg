$(document).ready(function () {
    var tipo = $('#tipo_cliente').val();
    setFields(tipo)
    $("#numero_documento").blur(function () {
        var val = $('#numero_documento').val();
        if (val.length >= 6) {
            $('#ruc').val(getDigitoVerificador(val))
        }
    });

    $("#nombre").blur(function () {
        var nombre = $('#nombre').val();
        var apellido = $('#apellido').val();
        $('#razon_social').val(nombre + ' ' + apellido);
    });
    $("#apellido").blur(function () {
        var nombre = $('#nombre').val();
        var apellido = $('#apellido').val();
        $('#razon_social').val(nombre + ' ' + apellido);
    });

    $('#tipo_cliente').on('change', function () {
        var tipo = $('#tipo_cliente').val();
        setFields(tipo);
    });

    function setFields(tipo) {
        var val = tipo == 2; // es juridico
        if (val) {
            $('#nombre').val('');
            $('#apellido').val('');
            $('#numero_documento').val('');
            $('#genero').val(1);
            $('#fecha_nacimiento').val(null);
        } else {
        }
        $('#numero_documento').attr('readonly', val);
        $('#tipo_documento').attr('readonly', val);
        $('#nombre').attr('readonly', val);
        $('#apellido').attr('readonly', val);
        $('#genero').attr('readonly', val);
        $('#fecha_nacimiento').attr('readonly', val);



    }

    function getDigitoVerificador(p_numero, p_basemax = 11) {
        p_numero = String(p_numero);
        p_basemax = Number(p_basemax);
        var v_total = 0;
        var v_resto = 0;
        var k = 0;
        var v_numero_aux = 0;
        var v_digit = 0;
        var v_numero_al = "";
        for (var i = 0; i < p_numero.length; i++) {
            var c = Number(p_numero.charAt(i));
            v_numero_al += c.toString();
        }
        k = 2;
        v_total = 0;
        for (var i = v_numero_al.length - 1; i >= 0; i--) {
            if (k > p_basemax) { k = 2 };
            v_numero_aux = Number(v_numero_al.charAt(i));
            v_total += (v_numero_aux * k);
            k = k + 1;
        }
        v_resto = v_total % 11;
        if (v_resto > 1) { v_digit = 11 - v_resto } else { v_digit = 0 };
        return p_numero + '-' + v_digit;
    }
});
