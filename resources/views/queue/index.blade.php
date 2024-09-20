@extends('layouts.layout')

@section('title', 'Fila')

@section('content')
    <div class="welcome-container">
        <h1>Voce esta na fila!</h1>
        <p class="welcome-text">Ola, voce esta aguardando a fila para poder comprar seu ingresso. Sua posicao na fila e:</p>
        <h2 id="queue-position">Carregando...</h2>
    </div>

    <script src="https://cdn.socket.io/4.0.0/socket.io.min.js"></script>
    <script>
        const userId = "{{ $userId }}";
        const batchId = "{{ $batchId }}";
        const socket = io('http://localhost:3000/monitoring', {
            withCredentials: true,
            transports: ['websocket'],
        });

        function manageQueue(userId, batchId) {
            socket.emit('manageQueue', { userId, batchId });
            socket.on('queuePosition', (data) => {
                document.getElementById('queue-position').innerHTML = `${data.position ?? data.initialPosition}º`;
            });
        }

        manageQueue(userId, batchId)
    </script>
    <link rel="stylesheet" href="{{ asset('css/queue.css') }}">
@endsection
