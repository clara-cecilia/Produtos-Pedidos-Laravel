<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <title>Criar Novo Pedido</title>
    <style>
        .produto-item {
            background-color: #f8f9fa;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #dee2e6;
        }
        .remove-produto {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Store</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Pedidos</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ route('pedidos.index') }}">Listar Pedidos</a></li>
                            <li><a class="dropdown-item" href="{{ route('pedidos.create') }}">Criar Pedido</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownProducts" role="button" data-bs-toggle="dropdown" aria-expanded="false">Produtos</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownProducts">
                            <li><a class="dropdown-item" href="{{ route('produtos.index') }}">Listar Produtos</a></li>
                            <li><a class="dropdown-item" href="{{ route('produtos.create') }}">Adicionar Produto</a></li>
                        </ul>
                    </li>
                </ul>
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1>Criar Novo Pedido</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Erro!</strong> Verifique os campos abaixo:
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if ($errors->has('estoque'))
            <div class="alert alert-danger">
                {{ $errors->first('estoque') }}
            </div>
        @endif

        <form action="{{ route('pedidos.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label class="form-label">Produtos:</label>
                <div id="produtos-container">
                    <div class="produto-item">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Produto</label>
                                <select name="produtos[0][id]" class="form-select produto-select" required>
                                    <option value="">Selecione um produto</option>
                                    @foreach ($produtos as $produto)
                                        <option value="{{ $produto->id }}" data-preco="{{ $produto->preco }}">
                                            {{ $produto->nome }} - R$ {{ number_format($produto->preco, 2, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Quantidade</label>
                                <input type="number" name="produtos[0][quantidade]" class="form-control quantidade" min="1" value="1" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Preço Unitário</label>
                                <input type="text" class="form-control preco-unitario" readonly>
                            </div>
                        </div>
                        <button type="button" class="btn btn-danger btn-sm remove-produto" style="display: none;">Remover</button>
                    </div>
                </div>
                
                <button type="button" id="add-produto" class="btn btn-secondary mt-2">
                    <i class="bi bi-plus"></i> Adicionar Produto
                </button>
            </div>

            <div class="mb-3">
                <label for="observacoes" class="form-label">Observações:</label>
                <textarea class="form-control" id="observacoes" name="observacoes" rows="3">{{ old('observacoes') }}</textarea>
            </div>

            <div class="mb-3">
                <strong>Total: </strong><span id="total-pedido">R$ 0,00</span>
            </div>

            <button type="submit" class="btn btn-primary">Criar Pedido</button>
            <a href="{{ route('pedidos.index') }}" class="btn btn-secondary">Voltar</a>
        </form>       
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('produtos-container');
            let produtoIndex = 1;
            
            // Adicionar novo produto
            document.getElementById('add-produto').addEventListener('click', function() {
                const newItem = document.createElement('div');
                newItem.className = 'produto-item';
                newItem.innerHTML = `
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Produto</label>
                            <select name="produtos[${produtoIndex}][id]" class="form-select produto-select" required>
                                <option value="">Selecione um produto</option>
                                @foreach ($produtos as $produto)
                                    <option value="{{ $produto->id }}" data-preco="{{ $produto->preco }}">
                                        {{ $produto->nome }} - R$ {{ number_format($produto->preco, 2, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Quantidade</label>
                            <input type="number" name="produtos[${produtoIndex}][quantidade]" class="form-control quantidade" min="1" value="1" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Preço Unitário</label>
                            <input type="text" class="form-control preco-unitario" readonly>
                        </div>
                    </div>
                    <button type="button" class="btn btn-danger btn-sm remove-produto">Remover</button>
                `;
                
                container.appendChild(newItem);
                produtoIndex++;
                
                // Mostrar botão de remover no primeiro item se houver mais de um
                if (container.children.length > 1) {
                    container.querySelectorAll('.remove-produto').forEach(btn => btn.style.display = 'block');
                }
                
                // Adicionar eventos ao novo item
                addProdutoEvents(newItem);
            });
            
            // Função para adicionar eventos a um item de produto
            function addProdutoEvents(item) {
                const select = item.querySelector('.produto-select');
                const quantidade = item.querySelector('.quantidade');
                const precoUnitario = item.querySelector('.preco-unitario');
                const removeBtn = item.querySelector('.remove-produto');
                
                // Atualizar preço quando selecionar produto
                select.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    const preco = selectedOption.getAttribute('data-preco');
                    precoUnitario.value = formatarMoeda(preco);
                    calcularTotal();
                });
                
                // Atualizar total quando mudar quantidade
                quantidade.addEventListener('input', calcularTotal);
                
                // Remover produto
                if (removeBtn) {
                    removeBtn.addEventListener('click', function() {
                        item.remove();
                        produtoIndex--;
                        calcularTotal();
                        
                        // Esconder botão de remover se só tiver um item
                        if (container.children.length === 1) {
                            container.querySelector('.remove-produto').style.display = 'none';
                        }
                    });
                }
            }

            // Calcular total do pedido
            function calcularTotal() {
                let total = 0;
                
                document.querySelectorAll('.produto-item').forEach(item => {
                    const select = item.querySelector('.produto-select');
                    const quantidade = item.querySelector('.quantidade').value;
                    
                    if (select.selectedIndex > 0 && quantidade > 0) {
                        const preco = parseFloat(select.options[select.selectedIndex].getAttribute('data-preco'));
                        total += preco * quantidade;
                    }
                });
                
                document.getElementById('total-pedido').textContent = formatarMoeda(total);
            }
            
            // Formatador de moeda
            function formatarMoeda(valor) {
                return 'R$ ' + parseFloat(valor).toFixed(2).replace('.', ',');
            }
            
            // Inicializar eventos no primeiro item
            addProdutoEvents(container.firstElementChild);
            
            // Atualizar preço unitário inicial
            const primeiroSelect = container.querySelector('.produto-select');
            if (primeiroSelect.selectedIndex > 0) {
                const preco = primeiroSelect.options[primeiroSelect.selectedIndex].getAttribute('data-preco');
                container.querySelector('.preco-unitario').value = formatarMoeda(preco);
            }
        });
    </script>
</body>
</html>