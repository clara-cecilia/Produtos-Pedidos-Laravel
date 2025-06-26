<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Visualizar Produto</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3>Detalhes do Produto</h3>
            </div>
            <div class="card-body">
                <p><strong>Nome:</strong> {{ $produto->nome }}</p>
                <p><strong>Custo:</strong> R$ {{ number_format($produto->custo, 2, ',', '.') }}</p>
                <p><strong>Preço:</strong> R$ {{ number_format($produto->preco, 2, ',', '.') }}</p>
                <p><strong>Quantidade:</strong> {{ $produto->quantidade }}</p>
            </div>
            <div class="card-footer">
                <a href="{{ route('produtos.index') }}" class="btn btn-secondary">Voltar</a>
            </div>
        </div>
    </div>
</body>
</html>
