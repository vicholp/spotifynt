<!DOCTYPE html>
<html lang="es">
<head>

  <title>@yield('title')</title>

  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
  <meta name="theme-color" content="#461B7E">
  <link rel="canonical" href="{{URL::current()}}">
  <meta name="description" content="@yield('meta_desc')">

  <!-- Imports -->

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <script src="https://code.iconify.design/2/2.0.3/iconify.min.js"></script>

    @yield('importHead')

</head>
<body class="dark bg-black">

    <div id="app" class="p-0 min-h-screen ">

        <!-- Navbar -->

          @include('template.navbar')

        <!-- Content -->

          @yield('content')

    </div>


  <!-- Footer -->

    @include('template.footer')

  <!-- Footer -->

    @include('template.brand')

  <!-- Imports -->

    @yield('importFoot')

    <script src="{{ asset('js/manifest.js') }}"></script>
    <script src="{{ asset('js/vendor.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>

</body>
</html>
