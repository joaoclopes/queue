@extends('layouts.layout')

@section('title', 'Lotes')

@section('content')
    <head>
        <link rel="stylesheet" href="{{ asset('css/batches.css') }}">
    </head>
    <h1>Lotes</h1>
    @include('batches.partials.create')

    @include('batches.partials.list')
@endsection
