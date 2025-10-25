<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prato;
use App\Models\Composicao;
use App\Models\Ingrediente;

class PratoController extends Controller
{
    private $prato;
    private $composicao;
    private $ingrediente;

    public function __construct()
    {
        $this->prato = new Prato();
        $this->composicao = new Composicao();
        $this->ingrediente = new Ingrediente();
    }

    public function index()
    {
        $pratos = $this->prato->listar();
        return view('pratos.index', compact('pratos'));
    }

    public function create()
    {
        $ingredientes = $this->ingrediente->listar();
        return view('pratos.create', compact('ingredientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'descricao' => 'required',
            'valor_unitario' => 'required|numeric',
            'ingredientes' => 'required|array',
            'quantidades' => 'required|array'
        ]);

        $cod_prato = $this->prato->inserir($request->descricao, $request->valor_unitario);

        foreach ($request->ingredientes as $i => $cod_ingrediente) {
            $quantidade = $request->quantidades[$i];
            $this->composicao->inserir($cod_ingrediente, $cod_prato, $quantidade);
        }

        return redirect('/pratos')->with('success', 'Prato cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $prato = $this->prato->buscar($id);
        return view('pratos.edit', compact('prato'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'descricao' => 'required',
            'valor_unitario' => 'required|numeric'
        ]);

        $this->prato->atualizar($id, $request->descricao, $request->valor_unitario);

        return redirect('/pratos')->with('success', 'Prato atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $this->prato->deletar($id);
        return redirect('/pratos')->with('success', 'Prato excluído com sucesso!');
    }
}
