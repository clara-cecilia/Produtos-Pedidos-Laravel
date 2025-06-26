<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Usuário</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Excluir Usuário</h1>

        <div class="alert alert-danger" role="alert">
            Tem certeza que deseja excluir o usuário <strong>{{ $user->name }}</strong>?
        </div>

<form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" id="delete-form">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza?')">
        Desativar Conta
    </button>
</form>

<script>
document.getElementById('delete-form').addEventListener('submit', function(e) {
    if(!confirm('Tem certeza que deseja desativar sua conta?')) {
        e.preventDefault();
    }
});
</script>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
