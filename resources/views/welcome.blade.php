<!DOCTYPE html>
<html>
<head>
    <title>Sistema de Ingressos</title>
</head>
<body>
    <h1>Fila de Compra de Ingressos</h1>
    <div id="queue"></div>

    <script src="{{ mix('js/app.js') }}"></script>
    <script>
        Echo.channel('queue-channel')
            .listen('.queue-updated', (event) => {
                console.log('Fila atualizada para o ingresso:', event.ticketId);
                // Atualize a interface do usuário com informações da fila
                fetchQueue(event.ticketId);
            });

        function fetchQueue(ticketId) {
            fetch(`/queue/${ticketId}`)
                .then(response => response.json())
                .then(data => {
                    const queueDiv = document.getElementById('queue');
                    queueDiv.innerHTML = `<p>Fila para ingresso ${ticketId}: ${data.queue}</p>`;
                });
        }
    </script>
</body>
</html>