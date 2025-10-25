<?php

namespace App\Models;

use App\Models\Conexao;

class Prato
{
    private $conn;

    public function __construct()
    {
        $this->conn = new Conexao();
    }

    public function listar()
    {
        $sql = "SELECT * FROM pratos ORDER BY cod_prato";
        return $this->conn->query($sql);
    }

    public function buscar($cod_prato)
    {
        $sql = "SELECT * FROM pratos WHERE cod_prato = ?";
        $res = $this->conn->query($sql, [$cod_prato]);
        return $res[0] ?? null;
    }

    public function inserir($descricao, $valor)
    {
        $res = $this->conn->callProcedure('sp_pratos_insert', [$descricao, $valor]);

        // $res deve ser algo como: [ ['cod_prato' => '7'] ]
        if (is_array($res) && isset($res[0]['cod_prato'])) {
            return (int) $res[0]['cod_prato'];
        }

        // fallback — se por algum motivo não veio resultado, tenta lastInsertId
        return (int) $this->conn->lastInsertId();
    }

    public function atualizar($cod_prato, $descricao, $valor)
    {
        return $this->conn->callProcedure('sp_pratos_update', [$cod_prato, $descricao, $valor]);
    }

    public function deletar($cod_prato)
    {
        return $this->conn->callProcedure('sp_pratos_delete', [$cod_prato]);
    }
}
