@extends('layouts.layout')

@section('title', 'Usuarios')

@section('content')
    <head>
        <link rel="stylesheet" href="{{ asset('css/users.css') }}">
    </head>
    <h1>Usuarios</h1>
    @include('users.partials.create')

    @include('users.partials.list')
@endsection
