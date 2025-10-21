<?php

namespace App\Models;

use App\Models\Conexao;

class ItemPedido
{
    private $conexao;

    public function __construct()
    {
        $this->conexao = new Conexao();
    }

    public function listar($codPedido)
    {
        $sql = "SELECT i.*, p.descricao AS prato, p.valor_unitario
                FROM itens_pedido i
                JOIN pratos p ON p.cod_prato = i.cod_prato
                WHERE i.cod_pedido = ?";
        return $this->conexao->query($sql, [$codPedido]);
    }

    public function adicionar($codPedido, $codPrato, $quantidade)
    {
        return $this->conexao->callProcedure('sp_itens_pedido_insert', [$codPedido, $codPrato, $quantidade]);
    }

    public function atualizar($codPedido, $codPrato, $quantidade)
    {
        return $this->conexao->callProcedure('sp_itens_pedido_update', [$codPedido, $codPrato, $quantidade]);
    }

    public function excluir($codPedido, $codPrato)
    {
        return $this->conexao->callProcedure('sp_itens_pedido_delete', [$codPedido, $codPrato]);
    }
}
