<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutosController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuarioController;

Route::get('/', function () {
    return view('home');
})->middleware('auth')->name('home');
;

// Rotas de produtos
Route::prefix('produtos')->name('produtos.')->middleware('auth')->group(function () {
    Route::get('/novo', [ProdutosController::class, 'create'])->name('create');
    Route::get('/', [ProdutosController::class, 'index'])->name('index');
    Route::post('/', [ProdutosController::class, 'store'])->name('store');
    Route::get('/ver/{id}', [ProdutosController::class, 'show'])->name('show');
    Route::get('/editar/{id}', [ProdutosController::class, 'edit'])->name('edit');
    Route::put('/{id}', [ProdutosController::class, 'update'])->name('update');
    Route::delete('/{id}', [ProdutosController::class, 'destroy'])->name('destroy');
    Route::get('/excluir/{id}', [ProdutosController::class, 'delete'])->name('delete');
});

// Rotas de pedidos
Route::prefix('pedidos')->name('pedidos.')->group(function () {
    Route::get('/', [PedidoController::class, 'index'])->name('index');
    Route::get('/create', [PedidoController::class, 'create'])->name('create');
    Route::post('/', [PedidoController::class, 'store'])->name('store');
    Route::get('/{pedido}', [PedidoController::class, 'show'])->name('show');
    Route::get('/{pedido}/edit', [PedidoController::class, 'edit'])->name('edit');
    Route::put('/{pedido}', [PedidoController::class, 'update'])->name('update');
    Route::delete('/{pedido}', [PedidoController::class, 'destroy'])->name('destroy');
    Route::get('/excluir/{pedido}', [ProdutosController::class, 'delete'])->name('delete');

});

// Rotas de autenticação
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', action: [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rotas protegidas
Route::middleware('auth')->group(function () {
    Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos.index');
    Route::get('/produtos', [ProdutosController::class, 'index'])->name('produtos.index');
    // Adicione aqui outras rotas que deseja proteger
});

Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');

// Rotas de página inicial
Route::get('/', function () {
    return view('home');
})->middleware('auth')->name('home');

// Rotas de produtos
Route::prefix('produtos')->name('produtos.')->middleware('auth')->group(function () {
    Route::get('/novo', [ProdutosController::class, 'create'])->name('create');
    Route::get('/', [ProdutosController::class, 'index'])->name('index');
    Route::post('/', [ProdutosController::class, 'store'])->name('store');
    Route::get('/ver/{id}', [ProdutosController::class, 'show'])->name('show');
    Route::get('/editar/{id}', [ProdutosController::class, 'edit'])->name('edit');
    Route::put('/{id}', [ProdutosController::class, 'update'])->name('update');
    Route::delete('/{id}', [ProdutosController::class, 'destroy'])->name('destroy');
    Route::get('/excluir/{id}', [ProdutosController::class, 'delete'])->name('delete');
});

// Rotas de pedidos
Route::prefix('pedidos')->name('pedidos.')->group(function () {
    Route::get('/', [PedidoController::class, 'index'])->name('index');
    Route::get('/create', [PedidoController::class, 'create'])->name('create');
    Route::post('/', [PedidoController::class, 'store'])->name('store');
    Route::get('/{pedido}/edit', [PedidoController::class, 'edit'])->name('edit');
    Route::put('/{pedido}', [PedidoController::class, 'update'])->name('update');
    Route::delete('/{pedido}', [PedidoController::class, 'destroy'])->name('destroy');
    Route::resource('pedidos', PedidoController::class)->middleware('auth');

});

// Rotas de usuários
Route::prefix('usuarios')->name('usuarios.')->middleware('auth')->group(function () {
    Route::get('/', [UsuarioController::class, 'index'])->name('index');
    Route::get('/criar', [UsuarioController::class, 'create'])->name('create'); 
    Route::post('/', [UsuarioController::class, 'store'])->name('store');
    Route::get('/{id}', [UsuarioController::class, 'show'])->name('show');
    Route::get('/{id}/editar', [UsuarioController::class, 'edit'])->name('edit');
    Route::put('/{id}', [UsuarioController::class, 'update'])->name('update');
    
    // Rota de exclusão CORRETA:
    Route::delete('/{id}', [UsuarioController::class, 'destroy'])->name('destroy');

});


// Rotas de autenticação
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rotas protegidas
Route::middleware('auth')->group(function () {
    Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos.index');
    Route::get('/produtos', [ProdutosController::class, 'index'])->name('produtos.index');
    // Adicione aqui outras rotas que deseja proteger
});


// Rotas públicas (sem autenticação)
Route::middleware('guest')->group(function () {
    Route::get('/register', [UsuarioController::class, 'create'])->name('register');
    Route::post('/register', [UsuarioController::class, 'store']);
});

// Rotas protegidas (requerem autenticação e conta ativa)
Route::middleware(['auth', 'active'])->group(function () {
    Route::get('/profile/{id}', [UsuarioController::class, 'show'])->name('profile.show');
    Route::get('/profile/{id}/edit', [UsuarioController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/{id}', [UsuarioController::class, 'update'])->name('profile.update');
    Route::delete('/profile/{id}', [UsuarioController::class, 'destroy'])->name('profile.destroy');
});


// Rotas públicas usuario
Route::middleware('guest')->group(function () {
    Route::get('/register', [UsuarioController::class, 'create'])->name('register');
    Route::post('/register', [UsuarioController::class, 'store']);
});

// Rotas autenticadas usuario
Route::middleware('auth')->group(function () {
    // Perfil do usuário
    Route::get('/profile/{id}', [UsuarioController::class, 'show'])->name('profile.show');
    Route::get('/profile/{id}/edit', [UsuarioController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/{id}', [UsuarioController::class, 'update'])->name('profile.update');
    
    // Desativar conta usuario
    Route::delete('/profile/{id}', [UsuarioController::class, 'destroy'])->name('profile.destroy');
});