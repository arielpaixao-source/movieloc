<?php

namespace App\Models;

use Config\Database;
use PDO;

class Filme 
{
    public static function listarTodos() 
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT * FROM filmes ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function buscarPorId($id) 
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT * FROM filmes WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public static function salvar($titulo, $genero, $ano_lancamento, $preco_locacao) 
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("INSERT INTO filmes (titulo, genero, ano_lancamento, preco_locacao) VALUES (:titulo, :genero, :ano, :preco)");
        return $stmt->execute([
            ':titulo' => $titulo,
            ':genero' => $genero,
            ':ano'    => $ano_lancamento,
            ':preco'  => $preco_locacao
        ]);
    }

    public static function atualizar($id, $titulo, $genero, $ano_lancamento, $preco_locacao) 
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("UPDATE filmes SET titulo = :titulo, genero = :genero, ano_lancamento = :ano, preco_locacao = :preco WHERE id = :id");
        return $stmt->execute([
            ':id'     => $id,
            ':titulo' => $titulo,
            ':genero' => $genero,
            ':ano'    => $ano_lancamento,
            ':preco'  => $preco_locacao
        ]);
    }

    public static function alterarStatus($id, $novoStatus) 
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("UPDATE filmes SET status = :status WHERE id = :id");
        return $stmt->execute([
            ':id'     => $id,
            ':status' => $novoStatus
        ]);
    }

    public static function excluir($id) 
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("DELETE FROM filmes WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}