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

    @vite(['resources/css/app.css', 'resources/js/app.js'], 'build')

    @stack('import_head')
</head>

<body class="bg-gray-100 dark:bg-black">
    @yield('content')

    @stack('import_foot')
</body>

</html>
