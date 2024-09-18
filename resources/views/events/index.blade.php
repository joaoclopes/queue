@extends('layouts.layout')

@section('title', 'Eventos')

@section('content')
    <head>
        <link rel="stylesheet" href="{{ asset('css/events.css') }}">
    </head>
    <h1>Eventos</h1>
    @include('events.partials.create')

    @include('events.partials.list')
@endsection
