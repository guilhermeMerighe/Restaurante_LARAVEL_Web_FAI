<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItemPedido;
use App\Models\Pedido;

class ItemPedidoController extends Controller
{
    private $itemPedido;

    public function __construct()
    {
        $this->itemPedido = new ItemPedido();
    }

    public function listar($cod_pedido)
    {
        $itens = $this->itemPedido->listar($cod_pedido);

        // Pega o valor total do pedido via Pedido model
        $pedidoModel = new Pedido();
        $valor_total = $pedidoModel->get_valor_total($cod_pedido);

        // Pega o status do pedido
        $status = $pedidoModel->getStatus($cod_pedido);

        return view('itens.index', compact('itens', 'cod_pedido', 'valor_total', 'status'));
    }


    public function adicionar(Request $request, $cod_pedido)
    {
        $codPrato = $request->input('cod_prato');
        $quantidade = $request->input('quantidade');

        try {
            $this->itemPedido->adicionar($cod_pedido, $codPrato, $quantidade);
            return redirect("/pedidos/{$cod_pedido}/itens")->with('success', 'Item adicionado com sucesso!');
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            if (str_contains($msg, 'Estoque insuficiente')) {
                $msg = 'Quantidade de Ingredientes Indisponíveis';
            }
            return redirect("/pedidos/{$cod_pedido}/itens")->with('error', $msg);
        }
    }



    public function atualizar(Request $request, $cod_pedido, $cod_prato)
    {
        $quantidade = $request->input('quantidade');

        try {
            $this->itemPedido->atualizar($cod_pedido, $cod_prato, $quantidade);
            return redirect("/pedidos/{$cod_pedido}/itens")->with('success', 'Quantidade atualizada!');
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            if (str_contains($msg, 'Estoque insuficiente')) {
                $msg = 'Quantidade de Ingredientes Indisponíveis';
            }
            return redirect("/pedidos/{$cod_pedido}/itens")->with('error', $msg);
        }
    }

    public function excluir($cod_pedido, $cod_prato)
    {
        try {
            $this->itemPedido->excluir($cod_pedido, $cod_prato);
            return redirect("/pedidos/{$cod_pedido}/itens")->with('success', 'Item removido!');
        } catch (\Exception $e) {
            return redirect("/pedidos/{$cod_pedido}/itens")->with('error', 'Erro: ' . $e->getMessage());
        }
    }


}
