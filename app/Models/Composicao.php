<?php

namespace App\Models;

use App\Models\Conexao;

class Composicao
{
    private $conn;

    public function __construct()
    {
        $this->conn = new Conexao();
    }

    public function listarPorPrato($cod_prato)
    {
        $sql = "SELECT c.*, i.descricao AS ingrediente
                FROM composicao c
                JOIN ingredientes i ON c.cod_ingrediente = i.cod_ingrediente
                WHERE c.cod_prato = ?";
        return $this->conn->query($sql, [$cod_prato]);
    }

    public function inserir($cod_ingrediente, $cod_prato, $quantidade)
    {
        return $this->conn->callProcedure('sp_composicao_insert', [$cod_ingrediente, $cod_prato, $quantidade]);
    }
}
