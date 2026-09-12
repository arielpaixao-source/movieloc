<?php

namespace App\Models;

use Config\Database;
use PDO;

class Cliente 
{
    public static function listarTodos() 
    {
        try {
            $db = Database::getConnection();
            $stmt = $db->query("SELECT * FROM clientes ORDER BY id DESC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw $e;
        }
    }

    public static function cadastrar($nome, $cpf, $telefone, $email) 
    {
        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("INSERT INTO clientes (nome, cpf, telefone, email) VALUES (:nome, :cpf, :telefone, :email)");
            return $stmt->execute([
                ':nome'     => $nome,
                ':cpf'      => $cpf,
                ':telefone' => $telefone,
                ':email'    => $email
            ]);
        } catch (\PDOException $e) {
            throw $e;
        }
    }

    public static function excluir($id) 
    {
        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("DELETE FROM clientes WHERE id = :id");
            return $stmt->execute([':id' => $id]);
        } catch (\PDOException $e) {
            throw $e;
        }
    }
}