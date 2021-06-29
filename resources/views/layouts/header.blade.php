<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>{{ env('APP_NAME') }}</title>

  <link rel="stylesheet" href="/css/app.css">
  <script src="/js/app.js"></script>
  <script type="text/javascript" src="{!! asset('js/jquery.print.js') !!}"></script>
</head>

<body>

<div class="wrapper print">
    <!-- Main content -->
    <div class="content">
        <main>
            @yield('content')
        </main>
    </div>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

@yield('scripts')

</body>
</html>
