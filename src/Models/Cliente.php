<?php

namespace App\Models;

use Config\Database;
use PDO;

class Cliente 
{
    public static function listarTodos() 
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT * FROM clientes ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function buscarPorId($id) 
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT * FROM clientes WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public static function salvar($nome, $cpf, $telefone, $email) 
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("INSERT INTO clientes (nome, cpf, telefone, email) VALUES (:nome, :cpf, :telefone, :email)");
        return $stmt->execute([
            ':nome'     => $nome,
            ':cpf'      => $cpf,
            ':telefone' => $telefone,
            ':email'    => $email
        ]);
    }

    public static function atualizar($id, $nome, $cpf, $telefone, $email) 
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("UPDATE clientes SET nome = :nome, cpf = :cpf, telefone = :telefone, email = :email WHERE id = :id");
        return $stmt->execute([
            ':id'       => $id,
            ':nome'     => $nome,
            ':cpf'      => $cpf,
            ':telefone' => $telefone,
            ':email'    => $email
        ]);
    }

    public static function excluir($id) 
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("DELETE FROM clientes WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}