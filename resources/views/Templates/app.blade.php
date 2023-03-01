<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Home</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    ....
    @vite('resources/css/app.css')
<body>
    <div id="app">
        @yield('content')
    </div>

    @vite('resources/js/app.js')
</body>
</html>
