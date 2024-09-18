<h2>Criar Evento</h2>

<form action="{{ route('createEvent') }}" method="POST" class="create-event-form">
    @csrf
    <div class="form-group">
        <label for="name">Nome:</label>
        <input type="text" id="name" name="name" class="form-control" required>
    </div>

    <div class="form-group button-group">
        <button type="submit" class="btn btn-primary">Criar</button>
    </div>
</form>
