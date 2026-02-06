<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta name="author" content="Mugdha Saha">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <link rel="shortcut icon" href="{{asset('images/favicon.png')}}">
        <title>@yield('title') - Account Management</title>
        <link rel="stylesheet" href="{{asset('assets/css/dashlite9b70.css?ver=3.3.0')}}">
        <link id="skin-default" rel="stylesheet" href="{{asset('assets/css/theme9b70.css?ver=3.3.0')}}">
    </head>
    <body class="font-sans text-gray-900 antialiased">
    @yield('content')
    </body>
    <script src="{{asset('assets/js/bundle9b70.js')}}"></script>
    <script src="{{asset('assets/js/scripts9b70.js')}}"></script>
    <script src="{{asset('assets/js/charts/gd-campaign9b70.js')}}"></script>
</html>
