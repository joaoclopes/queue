<h2>Criar Usuario</h2>

<form action="{{ route('createUser') }}" method="POST" class="create-user-form">
    @csrf
    <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="birth_date">Data de Nascimento:</label>
        <input type="birth_date" id="birth_date" name="birth_date" class="form-control" required>
    </div>

    <div class="form-group button-group">
        <button type="submit" class="btn btn-primary">Criar</button>
    </div>
</form>
