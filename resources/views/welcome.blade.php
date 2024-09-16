<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Comprar Ingresso</title>
  <script src="https://cdn.socket.io/4.0.0/socket.io.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
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
      const eventId = '9cfa6d66-9dc7-41dc-929d-86d18da78d14';

      fetch('/api/v1/event/user', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
          user_id: userId,
          event_id: eventId
        })
      })
      .then(response => {
        if (!response.ok) {
          Swal.fire({
            title: 'Erro na requisicao!',
            html: 'Ocorreu um erro na sua requisicao, tente novamente por gentileza!',
            icon: 'error',
            timer: 15000,
            showConfirmButton: true
          });
        }

        return response.json();
      })
      .then(data => {
        if (data.status == 409) {
        const url = new URL(data.redirect);
        url.searchParams.append('user_id', data.user_id);
        url.searchParams.append('event_id', data.event_id);
        window.location.href = url.toString();
      }
      })
      .catch(error => {
        Swal.fire({
            title: 'Ocorreu um erro ao tentar comprar o ingresso!',
            html: 'Infelizmente ocorreu um erro no sistema, tente novamente!',
            icon: 'error',
            showConfirmButton: true
          });
      });
    });
  </script>
</body>
</html>
