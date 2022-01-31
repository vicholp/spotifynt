<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8"/>

    <title></title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="">
    <meta name="robots" content="noindex, nofollow"/>

    <link rel="stylesheet" href="{{ mix('css/app.css')}}">

    @stack('import_head')
  </head>
  <body>
    <div id="app">
      @yield('content')

      @include('main.template.brand')
    </div>

    <script defer src="{{ mix('/js/manifest.js') }}"></script>
    <script defer src="{{ mix('/js/vendor.js') }}"></script>
    <script defer src="{{ mix('/js/app.js') }}"></script>

    @stack('import_foot')
  </body>
</html>
