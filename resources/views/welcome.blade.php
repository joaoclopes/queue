<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Queue Position</title>
  <script src="https://cdn.socket.io/4.0.0/socket.io.min.js"></script>
</head>
<body>
  <script>
    const socket = io('http://localhost:3000/monitoring', {
      withCredentials: true,
    }); // Conecta ao WebSocket na namespace 'queue'

    function manageQueue(userId, queueId) {
      socket.emit('manageQueue', { userId, queueId });
    }

    socket.on('queuePosition', (data) => {
      console.log(`User ${data.userId} position in queue: ${data.position}`);
      // Regras negociais, ex: ta na posicao 1? pode comprar?
    });

    // Funcao para conectar-se ao web socket
    const userId = '9cfa6cbf-9db4-4160-b26f-59e87273ed2b';
    const queueId = '9cfa6d66-9dc7-41dc-929d-86d18da78d14';
    manageQueue(userId, queueId);
  </script>
</body>
</html>
