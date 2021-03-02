$(document).ready(function () {
    $('.tabla-simple').DataTable({
        responsive: true,
    });
    $('.addAcceso').on('click', function () {
        addAcceso();
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
});