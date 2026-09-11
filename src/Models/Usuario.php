<?php

namespace App\Models;

use Config\Database;
use PDO;

class Usuario 
{
    public static function buscarPorEmail($email) 
    {
        try {
            $conn = Database::getConnection();
            $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = :email");
            $stmt->execute([':email' => $email]);
            return $stmt->fetch();
        } catch (\PDOException $e) {
            throw $e;
        }
    }

    public static function cadastrar($nome, $email, $senha) 
    {
        try {
            $conn = Database::getConnection();
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)");
            return $stmt->execute([
                ':nome'  => $nome,
                ':email' => $email,
                ':senha' => $senhaHash
            ]);
        } catch (\PDOException $e) {
            throw $e;
        }
    }
}