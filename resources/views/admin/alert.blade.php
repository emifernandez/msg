<head>
    @extends('adminlte::master')
</head>
@if ($errors->any())
    @section('js')
        <script>
            Swal.fire({
                position: 'top-end',
                title: 'Por favor verifique el formulario',
                text: 'No se pudo grabar los datos',
                icon: 'error',
                toast: true,
                timer: 5000,
                showConfirmButton: false,
            })
        </script>
    @stop
@endif

@if ($message = session('success'))
    @section('js')
        <script>
            Swal.fire({
                position: 'top-end',
                title: 'Por favor verifique el formulario',
                text: 'No se pudo grabar los datos',
                icon: 'error',
                toast: true,
                timer: 5000,
                showConfirmButton: false,
            })
        </script>
    @stop
    <?php Session::forget('success');?>
@endif

@if ($message = Session::get('error'))
    @section('js')
        <script>
            Swal.fire({
                position: 'top-end',
                title: 'Error',
                text: '<?php echo $message; ?>',
                icon: 'error',
                toast: true,
                timer: 5000,
                showConfirmButton: false,
            })
        </script>
    @stop
    <?php Session::forget('error');?>
@endif

@if ($message = Session::get('warning'))
    @section('js')
        <script>
            Swal.fire({
                position: 'top-end',
                title: 'Alerta',
                text: '<?php echo $message; ?>',
                icon: 'warning',
                toast: true,
                timer: 5000,
                showConfirmButton: false,
            })
        </script>
    @stop
    <?php Session::forget('warning');?>
@endif

@if ($message = Session::get('info'))
    @section('js')
        <script>
            Swal.fire({
                position: 'top-end',
                title: 'Info',
                text: '<?php echo $message; ?>',
                icon: 'info',
                toast: true,
                timer: 3000,
                showConfirmButton: false,
            })
        </script>
    @stop
    <?php Session::forget('info');?>
@endif
