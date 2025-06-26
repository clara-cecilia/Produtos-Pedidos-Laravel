<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produtos extends Model
{ 
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nome',
        'custo',
        'preco', 
        'quantidade',
        'is_active'
    ];

    protected $dates = ['deleted_at'];

    // Relacionamento com pedidos
    public function pedidos()
    {
        return $this->belongsToMany(Pedido::class, 'pedido_produto', 'produto_id', 'pedido_id')
                    ->withPivot('quantidade', 'preco_unitario')
                    ->withTimestamps();
    }

    // Scope para produtos ativos
    public function scopeAtivo($query)
    {
        return $query->where('is_active', true);
    }
}