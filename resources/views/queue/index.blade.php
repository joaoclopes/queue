@extends('layouts.layout')

@section('title', 'Fila')

@section('content')
    <div class="welcome-container">
        <h1>Voce esta na fila!</h1>
        <p class="welcome-text">Ola, voce esta aguardando a fila para poder comprar seu ingresso. Sua posicao na fila e:</p>
        <h2>1</h2>
    </div>

    <script>
        const userId = "{{ request('user_id') }}";
        const eventId = "{{ request('event_id') }}";
        const socket = io('http://localhost:3000/monitoring', {
            withCredentials: true,
            transports: ['websocket'],
        });
        
        function manageQueue(userId, eventId) {
            socket.emit('manageQueue', { userId, eventId });
            socket.on('queuePosition', (data) => {
                document.getElementById('queue-position').innerHTML = `Posicao na fila: ${data.position}`;
            });
        }

        // manageQueue(userId, eventId)
  </script>
    <link rel="stylesheet" href="{{ asset('css/queue.css') }}">
@endsection
