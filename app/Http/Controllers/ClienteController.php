<?php

namespace App\Http\Controllers;

use App\Models\Cliente;

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
}
