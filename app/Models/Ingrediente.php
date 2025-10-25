<?php

namespace App\Models;

use App\Models\Conexao;

class Ingrediente
{
    private $conexao;

    public function __construct()
    {
        $this->conexao = new Conexao();
    }

    public function listar()
    {
        return $this->conexao->query("SELECT * FROM ingredientes ORDER BY cod_ingrediente");
    }

    public function inserir($descricao, $unidade, $valor_unitario)
    {
        return $this->conexao->callProcedure('sp_ingredientes_insert', [
            $descricao, $unidade, $valor_unitario
        ]);
    }

    public function excluir($cod_ingrediente)
    {
        return $this->conexao->callProcedure('sp_ingredientes_delete', [$cod_ingrediente]);
    }

    public function adicionarEstoque($cod_ingrediente, $quantidade)
    {
        return $this->conexao->callProcedure('sp_estoque_add', [$cod_ingrediente, $quantidade]);
    }
}
