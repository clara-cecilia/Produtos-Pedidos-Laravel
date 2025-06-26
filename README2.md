# Regras de Negócio do Sistema (Cooperativa que todos podem fazer tudo)

## Autenticação e Usuários

1. **Cadastro de Usuários**
   - Todos podem se cadastrar como usuários comuns
   - O email deve ser único no sistema

2. **Acesso**
   - Usuários não autenticados só podem ver a página de login/cadastro
   - Usuários comuns só podem acessar (ler, editar, excluir) suas próprias informações
   - Usuários so podem ver email de outros usuarios

3. **Gerenciamento de Conta**
   - Usuários não podem excluir suas contas permanentemente
   - Usuários podem desativar suas contas (soft delete)

## Produtos

1. **CRUD de Produtos**
   - Usuários comuns podem apenas visualizar produtos ativos

## Pedidos

1. **Criação de Pedidos**
   - Apenas usuários autenticados podem criar pedidos
   - Um pedido deve conter pelo menos um produto
   - O valor total do pedido é calculado automaticamente

2. **Visualização de Pedidos**
   - Pedidos cancelados aparecem em uma lista separada

3. **Status do Pedido**
   - Pedidos podem ter os status: "Pendente", "Processando", "Enviado", "Entregue", "Cancelado".