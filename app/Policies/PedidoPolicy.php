<?php

namespace App\Policies;

use App\Models\Pedido;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PedidoPolicy
{
    public function view(User $user, Pedido $pedido)
    {
        return $user->is_admin || $pedido->user_id === $user->id;
    }

    public function update(User $user, Pedido $pedido)
    {
        return $user->is_admin || $pedido->user_id === $user->id;
    }

    public function delete(User $user, Pedido $pedido)
    {
        // Só permite cancelar pedidos pendentes
        return ($user->is_admin || $pedido->user_id === $user->id) 
               && $pedido->status === 'Pendente';
    }
}
