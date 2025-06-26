<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use App\Http\Controllers\Controller;


class UsuarioController extends Controller
{

    // Cadastro de novos usuários
    public function create()
    {
        return view('usuarios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'is_active' => true,
        ]);

        // Autentica o usuário após o cadastro
        Auth::login($user);

        return redirect()->route('home')->with('success', 'Cadastro realizado com sucesso!');
    }

    // Visualizar perfil (apenas o próprio usuário)
    public function show($id)
    {
        $user = User::findOrFail($id);
        
        // Verifica se o usuário autenticado pode visualizar
        if (Auth::id() !== $user->id) {
            abort(403, 'Acesso não autorizado.');
        }

        return view('usuarios.show', compact('user'));
    }

    // Editar perfil (apenas o próprio usuário)
    public function edit($id)
    {
        $user = User::findOrFail($id);
        
        // Verifica se o usuário autenticado pode editar
        if (Auth::id() !== $user->id) {
            abort(403, 'Acesso não autorizado.');
        }

        return view('usuarios.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        // Verifica se o usuário autenticado pode atualizar
        if (Auth::id() !== $user->id) {
            abort(403, 'Acesso não autorizado.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('usuarios.show', $user->id)
            ->with('success', 'Perfil atualizado com sucesso!');
    }


    // Se quiser restaurar um usuário deletado:
    public function restore($id)
    {
        $usuario = User::withTrashed()->findOrFail($id);
        $usuario->restore();

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuário restaurado com sucesso!');
    }
    
    public function index()
    {
    return view('usuarios.index', [
        'users' => User::all() // Defina explicitamente
    ]);}

    public function destroy($id)
{
    // Debug inicial (remova depois)
    logger()->info('Tentativa de exclusão', ['user_id' => $id, 'auth_id' => Auth::id()]);
    
    $user = User::findOrFail($id);

    if (Auth::id() !== $user->id) {
        abort(403, 'Acesso não autorizado.');
    }

    // Verificação antes da exclusão
    if($user->trashed()) {
        return back()->with('error', 'Este usuário já está desativado');
    }

    // Processo de exclusão
    try {
        $user->deactivate(); // Soft Delete
        
        Auth::logout();
        
        return redirect()->route('login')
               ->with('success', 'Conta desativada com sucesso.');
               
    } catch (\Exception $e) {
        logger()->error('Falha ao desativar usuário', [
            'error' => $e->getMessage(),
            'user' => $id
        ]);
        
        return back()->with('error', 'Erro ao desativar conta');
    }
}

}