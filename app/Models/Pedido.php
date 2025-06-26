<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pedido extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'total',
        'status',
        'observacoes'
    ];
 
    protected $dates = ['deleted_at'];

    // Relacionamento com usuário (cliente)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relacionamento muitos-para-muitos com produtos (CORRETO)
    public function produtos()
    {
        return $this->belongsToMany(Produtos::class, 'pedido_produto', 'pedido_id', 'produto_id')
                    ->withPivot('quantidade', 'preco_unitario')
                    ->withTimestamps();
    }

    // Acessor para obter o nome do cliente
    public function getClienteAttribute()
    {
        return $this->user->name;
    }

}