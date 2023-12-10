<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />

    <title></title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="">
    <meta name="robots" content="noindex, nofollow" />
    <link rel="canonical" href="{{ Request::url() }}">
    {!! \Sentry\Laravel\Integration::sentryTracingMeta() !!}

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Allura&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'], 'build')

    @stack('import_head')
</head>

<body class="bg-[#EFEFEF] dark:text-white dark:bg-[#101010]">
    <div id="app">
        @yield('content')
    </div>

    @stack('import_foot')
</body>

</html>
