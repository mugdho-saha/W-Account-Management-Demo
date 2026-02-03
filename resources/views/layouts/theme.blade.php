<!DOCTYPE html>
<html lang="en">
<head> <meta charset="utf-8">
    <meta name="author" content="Mugdha Saha">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <link rel="shortcut icon" href="{{asset('images/favicon.png')}}">
    <title>Account Management | Demo </title>
    <link rel="stylesheet" href="{{asset('assets/css/dashlite9b70.css?ver=3.3.0')}}">
    <link id="skin-default" rel="stylesheet" href="{{asset('assets/css/theme9b70.css?ver=3.3.0')}}">
</head>

<body class="nk-body ui-rounder has-sidebar ui-light">
<div class="nk-app-root">
    <div class="nk-main ">
        <div class="nk-sidebar is-light nk-sidebar-fixed " data-content="sidebarMenu">
            @include('components.theme.sidebar-head')
            @include('components.theme.sidebar-menu')
        </div>

        <div class="nk-wrap ">
            @include('components.theme.body-header')
            <div class="nk-content nk-content-fluid">
                <div class="container-xl wide-xl">
                    <div class="nk-content-body">
                        @yield('content')
                    </div>
                </div>
            </div>

            @include('components.theme.footer')
        </div>

    </div>
</div>

<script src="{{asset('assets/js/bundle9b70.js')}}"></script>
<script src="{{asset('assets/js/scripts9b70.js')}}"></script>
<script src="{{asset('assets/js/charts/gd-campaign9b70.js')}}"></script>
</body>
