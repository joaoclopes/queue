@extends('layouts.layout')

@section('title', 'Finalizar Compra')

@section('content')
    <head>
        <link rel="stylesheet" href="{{ asset('css/events.css') }}">
    </head>
    <h1>Finalizar Compra</h1>
    
    <div class="button-group">
        <form action="" method="POST" class="form-inline">
            @csrf
            <button type="submit" class="btn btn-success">Finalizar</button>
        </form>
        
        <form action="" method="POST" class="form-inline">
            @csrf
            <button type="submit" class="btn btn-danger">Cancelar</button>
        </form>
    </div>

<link rel="stylesheet" href="{{ asset('css/queue.css') }}">
@endsection
