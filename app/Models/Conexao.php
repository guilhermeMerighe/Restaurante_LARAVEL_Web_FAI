<?php

namespace App\Models;

use PDO;
use PDOException;

class Conexao
{
    private $host = 'localhost';
    private $db   = 'restaurante_laravel';
    private $user = 'root';
    private $pass = '';
    private $charset = 'utf8mb4';

    private $pdo;
    private $stmt;
    
    public function __construct()
    {
        $dsn = "mysql:host={$this->host};dbname={$this->db};charset={$this->charset}";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // lança exceção em erro
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // fetch como array associativo
            PDO::ATTR_EMULATE_PREPARES   => false,                  // desabilita prepares emulado
        ];

        try {
            $this->pdo = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            die("Erro de conexão: " . $e->getMessage());
        }
    }

    /**
     * Executa uma query SQL simples (SELECT, INSERT, UPDATE, DELETE)
     * @param string $sql
     * @param array $params
     * @return array|bool
     */
    public function query(string $sql, array $params = [])
    {
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->execute($params);

        // Se for SELECT, retorna os resultados
        if (stripos(trim($sql), 'SELECT') === 0) {
            return $this->stmt->fetchAll();
        }

        // Para INSERT/UPDATE/DELETE retorna verdadeiro se executou
        return true;
    }

    /**
     * Executa um procedimento armazenado
     * @param string $procNome
     * @param array $params
     * @return array|bool
     */
    public function callProcedure(string $procNome, array $params = [])
    {
        // Monta placeholders para PDO
        $placeholders = implode(',', array_fill(0, count($params), '?'));
        $sql = "CALL {$procNome}({$placeholders})";
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->execute(array_values($params));

        // Tenta retornar resultados se houver SELECT dentro do procedure
        try {
            return $this->stmt->fetchAll();
        } catch (\Exception $e) {
            return true; // se não houver resultados
        }
    }

    /**
     * Retorna o último ID inserido
     */
    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }
}

?>