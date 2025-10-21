<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;

class PedidoController extends Controller
{
    private $pedido;

    public function __construct()
    {
        $this->pedido = new Pedido();
    }

    public function index()
    {
        $pedidos = $this->pedido->listar();
        return view('pedidos.index', compact('pedidos'));
    }

    public function criar(Request $request)
    {
        $codCliente = $request->input('cod_cliente');
        $this->pedido->criar($codCliente);
        return redirect('/pedidos')->with('success', 'Pedido criado com sucesso!');
    }

    public function finalizar($cod_pedido)
    {
        $this->pedido->finalizar($cod_pedido);
        return redirect('/pedidos')->with('success', 'Pedido finalizado!');
    }
}
