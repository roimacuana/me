<!DOCTYPE html>
<html ng-app="Test">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta name="csrf_token" content="{{csrf_token()}}" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,800" rel="stylesheet">

    <base href="/">
    @stack('metas')

    <title> Test - @yield('title')</title>
    @yield('styles')@stack('styles')
    <style>
        .loader.active:after{
            content: '';
            background-image: url(/loader/loader-spiner.gif);
            position: fixed;
            width: 100%;
            height: 100vh;
            top: 0;
            right: 0;
            background-size: 10%;
            background-position: center;
            background-color: rgba(192,192,192,0.8);
            background-repeat: no-repeat;
            z-index: 99;
        }
    </style>
    @yield('scripts')@stack('scripts')
    <script type="text/javascript">
        $(window).on('load',function() {
            $(".loader").removeClass('active');
        });
    </script>
</head>
<body class="loader active {{ isset($class) ? $class : '' }}">
@yield('layout')
</body>
</html>