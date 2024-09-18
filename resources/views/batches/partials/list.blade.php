<h1>Lotes</h1>

<table class="batch-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome do Lote</th>
            <th>Evento</th>
            <th>Vagas</th>
            <th>Vagas Disponiveis</th>
            <th>Criado em</th>
        </tr>
    </thead>
    <tbody>
        @foreach($batches as $batch)
        <tr>
            <td>{{ $batch->id }}</td>
            <td>{{ $batch->name }}</td>
            <td>{{ $batch->event ? $batch->event->name : 'N/A' }}</td>
            <td>{{ $batch->slots }}</td>
            <td>{{ $batch->slots_available }}</td>
            <td>{{ $batch->created_at->format('d/m/Y H:i') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>