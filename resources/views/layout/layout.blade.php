@extends('layout.master')

@section('body')
    @include('layout.navbar')
    @include('layout.sidebar')
    <div class="containr">
        @yield('container')
    </div>
@endsection