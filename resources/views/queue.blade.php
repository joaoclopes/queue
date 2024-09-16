<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Fila</title>
  <script src="https://cdn.socket.io/4.0.0/socket.io.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body>
  <div class="queue-container">
    <h2>Posicao na fila</h2>
    <div class="input-group">
    <p id="queue-position" class="queue-position">Carregando...</p>
    </div>
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

    manageQueue(userId, eventId)
  </script>
</body>
</html>
