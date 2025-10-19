<?php

namespace App\Models;

use App\Models\Conexao;

class Cliente
{
    private $db;

    public function __construct()
    {
        $this->db = new Conexao();
    }

    public function listarTodos()
    {
        return $this->db->query("SELECT * FROM clientes ORDER BY cod_cliente DESC");
    }

    public function buscarPorId($id)
    {
        $sql = "SELECT * FROM clientes WHERE cod_cliente = ?";
        $resultado = $this->db->query($sql, [$id]);
        return $resultado[0] ?? null;
    }

    public function buscarPedidosPorCliente($id)
    {
        $sql = "
            SELECT p.cod_pedido, p.data_pedido, SUM(ip.quantidade * ip.valor_unitario) AS total
            FROM pedidos p
            LEFT JOIN itens_pedido ip ON ip.cod_pedido = p.cod_pedido
            WHERE p.cod_cliente = ?
            GROUP BY p.cod_pedido, p.data_pedido
            ORDER BY p.data_pedido DESC
        ";
        return $this->db->query($sql, [$id]);
    }
}
