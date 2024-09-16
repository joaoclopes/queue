<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Comrpar Ingresso</title>
  <script src="https://cdn.socket.io/4.0.0/socket.io.min.js"></script>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f9;
      margin: 0;
      padding: 20px;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .queue-container {
      background-color: #fff;
      border-radius: 8px;
      padding: 30px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      max-width: 400px;
      width: 100%;
    }
    h2 {
      text-align: center;
      color: #333;
    }
    .input-group {
      margin-bottom: 20px;
    }
    label {
      font-size: 14px;
      color: #555;
    }
    input {
      width: 100%;
      padding: 10px;
      border-radius: 4px;
      border: 1px solid #ddd;
      margin-top: 5px;
    }
    button {
      width: 100%;
      padding: 10px;
      background-color: #28a745;
      color: white;
      border: none;
      border-radius: 4px;
      font-size: 16px;
      cursor: pointer;
    }
    button:hover {
      background-color: #218838;
    }
    .message {
      text-align: center;
      margin-top: 15px;
      font-size: 14px;
      color: #666;
    }
  </style>
</head>
<body>
  <div class="queue-container">
    <h2>Comprar ingresso</h2>
    <form id="queueForm" method="POST" action="/buy-ticket">
      <div class="input-group">
        <label for="userId">User ID</label>
        <input type="text" id="userId" name="userId" placeholder="Coloque um ID de usuario" required />
      </div>
      <button type="submit">Comprar</button>
      <p class="message" id="queueMessage"></p>
    </form>
  </div>

  <script>
    const form = document.getElementById('queueForm');
    const message = document.getElementById('queueMessage');

    form.addEventListener('submit', function (e) {
      e.preventDefault();
      const userId = document.getElementById('userId').value;

      const socket = io('http://localhost:3000/monitoring', { withCredentials: true });
      const queueId = '9cfa6d66-9dc7-41dc-929d-86d18da78d14';
      
      socket.emit('manageQueue', { userId, queueId });

      socket.on('queuePosition', (data) => {
        message.textContent = `Your position in queue: ${data.position}`;
      });

      fetch('/buy-ticket', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ userId })
      })
      .then(response => response.json())
      .then(data => {
        message.textContent = data.message || 'Joined the queue successfully!';
      })
      .catch(error => {
        message.textContent = 'An error occurred. Please try again.';
        console.error('Error:', error);
      });
    });
  </script>
</body>
</html>
