<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Usuário</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Detalhes do Usuário</h1>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Nome: {{ $user->name }}</h5>
                <p class="card-text"><strong>Email:</strong> {{ $user->email }}</p>
                <p class="card-text"><strong>Data de Criação:</strong> {{ $user->created_at->format('d/m/Y H:i') }}</p>
                <p class="card-text"><strong>Verificado:</strong> {{ $user->email_verified_at ? 'Sim' : 'Não' }}</p>

                <a href="{{ route('usuarios.edit', $user->id) }}" class="btn btn-warning">Editar</a>
                <a href="{{ route('usuarios.destroy', parameters: $user->id) }}" class="btn btn-danger btn-sm">Excluir</a>
                <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Voltar</a>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
