<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, SoftDeletes;

    protected $fillable = [
        'name', 
        'email', 
        'password',
        'is_active'
    ];

    protected $hidden = [
        'password', 
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    protected $dates = ['deleted_at'];

    // Mutator para garantir email em lowercase
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }

    // Desativar conta (soft delete)
    public function deactivate()
    {
        $this->update(['is_active' => false]);
        $this->delete();
    }

    // Restaurar conta
    public function restoreAccount()
    {
        $this->restore();
        $this->update(['is_active' => true]);
    }

        public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }

}