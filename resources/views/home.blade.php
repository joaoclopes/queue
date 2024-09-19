@extends('layouts.layout')

@section('title', 'Home')

@section('content')
    <div class="welcome-container">
        <h1>
            Bem-vindo
        </h1>
        <p class="welcome-text">
            Selecione o Usuário e o Lote para o evento desejado. O sistema irá verificar se existe fila ou está disponível para compra.
        </p>

        <form id="purchaseForm" class="welcome-form">
            @csrf
            <div class="form-group">
                <label for="user_id">Usuário:</label>
                <select id="user_id" name="user_id" class="form-control" required>
                    <option value="">Selecione um usuário</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="event_id">Evento:</label>
                <select id="event_id" name="event_id" class="form-control" required>
                    <option value="">Selecione um evento</option>
                    @foreach($events as $event)
                        <option value="{{ $event->id }}">{{ $event->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="batch_id">Lote:</label>
                <select id="batch_id" name="batch_id" class="form-control" required>
                    <option value="">Selecione um lote</option>
                </select>
            </div>

            <div class="form-group button-group">
                <button type="submit" class="btn btn-primary">Enviar</button>
            </div>
        </form>
    </div>

    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const eventSelect = document.getElementById('event_id');
            const batchSelect = document.getElementById('batch_id');
            const form = document.getElementById('purchaseForm');

            eventSelect.addEventListener('change', function() {
                const eventId = eventSelect.value;

                batchSelect.innerHTML = '<option value="">Selecione um lote</option>';

                if (eventId) {
                    fetch(`api/v1/batch/event/${eventId}`)
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(batch => {
                                const option = document.createElement('option');
                                option.value = batch.id;
                                option.textContent = batch.name;
                                batchSelect.appendChild(option);
                            });
                        });
                }
            });

            form.addEventListener('submit', function(event) {
                event.preventDefault();

                const formData = new FormData(form);
                const userId = document.getElementById('user_id').value;
                const batchId = document.getElementById('batch_id').value;

                fetch("{{ route('buyBatch') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.queue) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Voce foi adicionado a fila!',
                            text: data.message,
                            showConfirmButton: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = `/queue/${userId}/${batchId}`;
                            }
                        });
                        return;
                    }
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Compra realizada com sucesso!',
                            text: data.message,
                            showConfirmButton: 'OK'
                        });
                        return;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro!',
                        text: data.message,
                        timer: 3000,
                        showConfirmButton: false
                    });
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro!',
                        text: 'Ocorreu um erro ao processar sua solicitação.',
                        timer: 3000,
                        showConfirmButton: false
                    });
                });
            });
        });
    </script>
@endsection
