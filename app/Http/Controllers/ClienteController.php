<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    private $cliente;

    public function __construct()
    {
        $this->cliente = new Cliente();
    }

    public function index()
    {
        $clientes = $this->cliente->listarTodos();
        return view('clientes.index', compact('clientes'));
    }

    public function detalhes($id)
    {
        $cliente = $this->cliente->buscarPorId($id);
        $pedidos = $this->cliente->buscarPedidosPorCliente($id);

        if (!$cliente) {
            abort(404, 'Cliente não encontrado');
        }

        return view('clientes.detalhes', compact('cliente', 'pedidos'));
    }

     public function create()
    {
        return view('clientes.create');
    }

    public function store(Request $request)
    {
        $dados = [
            'nome' => $request->input('nome'),
            'telefone' => $request->input('telefone'),
            'cpf' => $request->input('cpf'),
            'rg' => $request->input('rg'),
            'endereco' => $request->input('endereco'),
            'email' => $request->input('email'),
        ];

        $this->cliente->inserir($dados);

        return redirect()->route('clientes.index')->with('success', 'Cliente cadastrado com sucesso!');
    }

    
}
