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
        try {
            $this->pedido->finalizar($cod_pedido);
            if(request()->wantsJson()){
                return response()->json(['success' => 'Pedido finalizado!']);
            }
            return redirect("/pedidos/{$cod_pedido}/itens")->with('success', 'Pedido finalizado!');
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            if(request()->wantsJson()){
                return response()->json(['error' => $msg], 500);
            }
            return redirect("/pedidos/{$cod_pedido}/itens")->with('error', $msg);
        }
    }
}
