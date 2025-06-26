<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    // ... outras propriedades

    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'active' => \App\Http\Middleware\CheckActiveAccount::class,
        // ... outros middlewares
    ];

    // ... outros métodos
}