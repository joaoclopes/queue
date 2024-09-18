@extends('layouts.layout')

@section('title', 'Home')

@section('content')
    <div class="welcome-container">
        <h1>
            Bem-vindo
        </h1>
        <p class="welcome-text">
            Selecione o Usuario e o Lote para o evento desejado. O sistema irá verificar se existe fila ou está disponível para compra.
        </p>

        
        
        <form action="{{ route('buyBatch') }}" method="POST" class="welcome-form">
            @csrf
            <div class="form-group">
                <label for="user_id">Usuario:</label>
                <select id="user_id" name="user_id" class="form-control" required>
                    <option value="">Selecione um usuario</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="event_id">Evento:</label>
                <select id="event_id" name="event_id" class="form-control" required>
                    <option value="">Selecione um evento</option>
                    @foreach($events as $event)
                        <option value="{{ $event->id }}">{{ $event->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="batch_id">Lote:</label>
                <select id="batch_id" name="batch_id" class="form-control" required>
                    <option value="">Selecione um lote</option>
                </select>
            </div>

            <div class="form-group button-group">
                <button type="submit" class="btn btn-primary">Enviar</button>
            </div>
        </form>
    </div>

    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const eventSelect = document.getElementById('event_id');
            const batchSelect = document.getElementById('batch_id');

            eventSelect.addEventListener('change', function() {
                const eventId = eventSelect.value;

                batchSelect.innerHTML = '<option value="">Selecione um lote</option>';

                if (eventId) {
                    fetch(`api/v1/batch/event/${eventId}`)
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(batch => {
                                const option = document.createElement('option');
                                option.value = batch.id;
                                option.textContent = batch.name;
                                batchSelect.appendChild(option);
                            });
                        });
                }
            });
        });
    </script>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection
