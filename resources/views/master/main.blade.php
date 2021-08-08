<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Gloria Hallelujah' rel='stylesheet'>
    <link rel="stylesheet" href="//fonts.googleapis.com/icon?family=Material+Icons">

    <!-- Styles -->
    <link href="{{ asset('css/eps.css') }}" rel="stylesheet">

    @yield('styles')
</head>
<body>
@component('master.header')
@endcomponent
<main>

    <div id="app">
        @yield('content')
    </div>


</main>
@component('master.footer')
@endcomponent
<!-- Scripts -->
<script  src="{{ asset('js/app.js') }}" ></script>

<script type="application/javascript" src="{{ asset('js/exercises-students/memory-game-students.js') }}"> </script>


@yield('scripts')
</body>
</html>
