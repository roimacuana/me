@extends('app')

@section('styles')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link type="text/css" rel="stylesheet" href="{{url('css/style.css')}}" />
@endsection

@section('scripts')
<script type="text/javascript" src="{{url('vendor/node_modules/jquery/dist/jquery.min.js')}}"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="{{url('js/script.js')}}"></script>
@endsection

@section('layout')
<div class="wrapper">
    <header>
        <div class="menu-bar">
            <div class="container">
                <div class="logo">

                </div>
                <div class="menu">
                a
                </div>
                <div class="mobile-menu">

                </div>
            </div>
        </div>
    </header>
    <div class="main">@yield('content')</div>
    <footer>
        <div class="container">

        </div>
    </footer>
</div>
@endsection