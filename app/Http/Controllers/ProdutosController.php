<?php

namespace App\Http\Controllers;
use App\Models\Produtos;
use App\Models\User;


use Illuminate\Http\Request;

class ProdutosController extends Controller
{

    public function index()
    {
        $produtos = Produtos::all();
        return view('produtos.index', compact('produtos')); 
    }
    

    public function create(){
        return view('produtos.create');
    }

    public function show($id)
    {
        $produto = Produtos::findOrFail($id);
        return view('produtos.show', ['produto' => $produto]);
    }
    public function edit($id)
    {
        $produto = Produtos::findOrFail($id);
        return view('produtos.edit', ['produto' => $produto]);
    }
    public function update(Request $request,$id)
    {
        $produto = Produtos::findOrFail($id);
        $produto -> update([
            'nome' => $request->nome,
            'custo' => $request->custo,
            'preco' => $request->preco,
            'quantidade' => $request->quantidade
        ]);
        return redirect()->route('produtos.index')->with('success', 'Produto atualizado com sucesso!');
    }

    public function delete($id)
    {
        $produto = Produtos::findOrFail($id);
        return view('produtos.delete', ['produto' => $produto]);
    }
     

    public function destroy($id)
    {
        $produto = Produtos::findOrFail($id);
        $produto->delete();
    
        // Redirecionar após a exclusão com uma mensagem de sucesso
        return redirect()->route('produtos.index')->with('success', 'Produto excluído com sucesso!');
    }
    
    public function store(Request $request)
    {
        // Validação dos dados do produto
        $request->validate([
            'nome' => 'required|string|max:255',
            'custo' => 'required|numeric',
            'preco' => 'required|numeric',
            'quantidade' => 'required|integer',
        ]);
    
        // Criação do novo produto
        $produto = Produtos::create([
            'nome' => $request->nome,
            'custo' => $request->custo,
            'preco' => $request->preco,
            'quantidade' => $request->quantidade,
        ]);
    
        // Redirecionar para a página do produto recém-criado, com uma mensagem de sucesso
        return redirect()->route('produtos.show', ['id' => $produto->id])->with('success', 'Produto cadastrado com sucesso!');

        
    }
    

}
