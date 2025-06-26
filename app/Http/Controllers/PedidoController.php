<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Produtos;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class PedidoController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        if (Auth::user()->is_admin) {
            $pedidos = Pedido::with(['user', 'produtos'])->latest()->get();
        } else {
            $pedidos = Auth::user()->pedidos()->with('produtos')->latest()->get();
        }
    
        return view('pedidos.index', compact('pedidos'));
    }

    public function create()
    {
        $produtos = Produtos::ativo()->get();
        return view('pedidos.create', compact('produtos'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'produtos' => 'required|array|min:1',
            'produtos.*.id' => 'required|exists:produtos,id',
            'produtos.*.quantidade' => 'required|integer|min:1',
            'observacoes' => 'nullable|string'
        ]);

        // Verifica estoque antes de processar
        foreach ($validatedData['produtos'] as $item) {
            $produto = Produtos::find($item['id']);
            if ($produto->quantidade < $item['quantidade']) {
                return back()->withErrors([
                    'estoque' => "Quantidade insuficiente do produto {$produto->nome}. Estoque disponível: {$produto->quantidade}"
                ])->withInput();
            }
        }

        // Calcula o total
        $total = 0;
        foreach ($validatedData['produtos'] as $item) {
            $produto = Produtos::find($item['id']);
            $total += $produto->preco * $item['quantidade'];
        }

        // Cria o pedido
        $pedido = Pedido::create([
            'user_id' => Auth::id(),
            'total' => $total,
            'status' => 'Pendente',
            'observacoes' => $validatedData['observacoes'] ?? null
        ]);

        // Adiciona produtos ao pedido e atualiza estoque
        foreach ($validatedData['produtos'] as $item) {
            $produto = Produtos::find($item['id']);
            $pedido->produtos()->attach($produto->id, [
                'quantidade' => $item['quantidade'],
                'preco_unitario' => $produto->preco
            ]);
        
            // Atualiza o estoque
            $produto->decrement('quantidade', $item['quantidade']);
        }

        return redirect()->route('pedidos.index')->with('success', 'Pedido criado com sucesso!');
    }

    public function show(Pedido $pedido)
    {
        // Verifica se o usuário tem permissão para ver este pedido
        $this->authorize('view', $pedido);
        
        $pedido->load(['user', 'produtos']);
        return view('pedidos.show', compact('pedido'));
    }

    public function edit(Pedido $pedido)
    {
        $this->authorize('update', $pedido);
        
        $produtos = Produtos::ativo()->get();
        $pedido->load('produtos');
        return view('pedidos.edit', compact('pedido', 'produtos'));
    }

    public function update(Request $request, Pedido $pedido)
    {
        $this->authorize('update', $pedido);

        $validatedData = $request->validate([
            'status' => 'required|in:Pendente,Processando,Enviado,Entregado,Cancelado',
            'observacoes' => 'nullable|string'
        ]);

        $pedido->update($validatedData);

        return redirect()->route('pedidos.index')
                         ->with('success', 'Pedido atualizado com sucesso!');
    }

    public function destroy(Pedido $pedido)
    {
        $this->authorize('delete', $pedido);
    
        // Devolve os produtos ao estoque
        foreach ($pedido->produtos as $produto) {
            $produto->increment('quantidade', $produto->pivot->quantidade);
        }
    
        $pedido->delete();
    
        return redirect()->route('pedidos.index')->with('success', 'Pedido cancelado e estoque atualizado com sucesso!');
    }
}