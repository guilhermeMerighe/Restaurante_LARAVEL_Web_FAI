<?php

namespace App\Models;

use App\Models\Conexao;

class Pedido
{
    private $conexao;

    public function __construct()
    {
        $this->conexao = new Conexao();
    }

    public function get_valor_total($codPedido)
    {
        $sql = "SELECT valor_total FROM pedidos WHERE cod_pedido = ?";
        $res = $this->conexao->query($sql, [$codPedido]);
        return $res[0]['valor_total'] ?? 0;
    }

    public function listar()
    {
        $sql = "SELECT p.*, c.nome AS cliente_nome
                FROM pedidos p
                JOIN clientes c ON c.cod_cliente = p.cod_cliente
                ORDER BY p.cod_pedido DESC";
        return $this->conexao->query($sql);
    }

    public function criar($codCliente)
    {
        return $this->conexao->callProcedure('sp_pedidos_insert', [$codCliente]);
    }

    public function finalizar($codPedido)
    {
        return $this->conexao->callProcedure('sp_pedidos_finalize', [$codPedido]);
    }

    public function buscar($codPedido)
    {
        $sql = "SELECT * FROM pedidos WHERE cod_pedido = ?";
        $res = $this->conexao->query($sql, [$codPedido]);
        return $res[0] ?? null;
    }
}
