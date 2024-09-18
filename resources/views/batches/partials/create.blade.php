<h2>Criar Lote</h2>

<form action="{{ route('createBatch') }}" method="POST" class="create-batch-form">
    @csrf
    <div class="form-group">
        <label for="name">Nome:</label>
        <input type="text" id="name" name="name" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="event_id">Evento:</label>
        <select id="event_id" name="event_id" class="form-control" required>
            <option value="" disabled selected>Escolha um evento</option>
            @foreach($events as $event)
                <option value="{{ $event->id }}">{{ $event->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="slots">Vagas Totais:</label>
        <input type="text" id="slots" name="slots" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="slots_available">Vagas Disponiveis:</label>
        <input type="text" id="slots_available" name="slots_available" class="form-control" required>
    </div>

    <div class="form-group button-group">
        <button type="submit" class="btn btn-primary">Criar</button>
    </div>
</form>
