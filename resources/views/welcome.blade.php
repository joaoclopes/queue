<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste de fila</title>
</head>
<body>
    <h1>Sistema de fila com Redis e SSE</h1>
    <div id="messages"></div>

    <script>
        const eventSource = new EventSource('api/v1/sse');

        eventSource.onmessage = function(event) {
            const message = JSON.parse(event.data).message;
            document.getElementById('messages').innerHTML = `<p>${message}</p>`;
            if (JSON.parse(event.data).position == 0) {
                eventSource.close();
            }
        };

        eventSource.onerror = function() {
            console.error("Erro na conexão com o SSE.");
            eventSource.close();
        };
    </script>
</body>
</html>
