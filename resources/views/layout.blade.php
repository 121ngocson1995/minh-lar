@extends('layouts.app')

@section('content')
    @yield('title')

    @yield('table')

    @yield('order')

    <hr>

    <div style="text-align: center;">
        <h3>Application cache test:</h3>
        <br>
        <audio controls>
            {{-- <source src="/audio/01_A_Turtles_Heart.wav" type="audio/wav"> --}}
            <source src="/audio/1.03.RTRT-Mili.mp3" type="audio/mp3">
                Your browser does not support the audio element.
            </audio>
        </div>

@stop