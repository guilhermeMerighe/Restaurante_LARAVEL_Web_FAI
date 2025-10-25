<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingrediente;

class IngredienteController extends Controller
{
    private $ingrediente;

    public function __construct()
    {
        $this->ingrediente = new Ingrediente();
    }

    // Página inicial: lista de ingredientes
    public function index()
    {
        $ingredientes = $this->ingrediente->listar();
        return view('ingredientes.index', compact('ingredientes'));
    }

    // Formulário para novo ingrediente
    public function create()
    {
        return view('ingredientes.create');
    }

    // Armazena novo ingrediente
    public function store(Request $request)
    {
        $request->validate([
            'descricao' => 'required|string|max:30',
            'unidade' => 'required|in:0,1',
            'valor_unitario' => 'required|numeric|min:0',
        ]);

        $this->ingrediente->inserir(
            $request->descricao,
            $request->unidade,
            $request->valor_unitario
        );

        return redirect('/ingredientes')->with('success', 'Ingrediente adicionado com sucesso!');
    }

    // Exclui ingrediente
    public function destroy($cod_ingrediente)
    {
        $this->ingrediente->excluir($cod_ingrediente);
        return redirect('/ingredientes')->with('success', 'Ingrediente removido!');
    }

    // Adiciona quantidade ao estoque
    public function adicionarEstoque(Request $request, $cod_ingrediente)
    {
        $request->validate([
            'quantidade' => 'required|integer|min:1',
        ]);

        $this->ingrediente->adicionarEstoque($cod_ingrediente, $request->quantidade);

        return redirect('/ingredientes')->with('success', 'Estoque atualizado!');
    }
}
