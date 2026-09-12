<?php

namespace App\Models;

use Config\Database;
use PDO;

class Locacao 
{
    public static function listarTodas() 
    {
        try {
            $conn = Database::getConnection();
            $query = "SELECT l.*, f.titulo as filme_titulo, c.nome as cliente_nome 
                      FROM locacoes l
                      JOIN filmes f ON l.filme_id = f.id
                      JOIN clientes c ON l.cliente_id = c.id
                      ORDER BY l.id DESC";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            throw $e;
        }
    }

    public static function salvar($filme_id, $cliente_id, $data_devolucao_prevista) 
    {
        $conn = Database::getConnection();
        try {
            $conn->beginTransaction();
            $stmt = $conn->prepare("INSERT INTO locacoes (filme_id, cliente_id, data_devolucao_prevista) VALUES (:filme_id, :cliente_id, :data_prevista)");
            $sucesso = $stmt->execute([
                ':filme_id'      => $filme_id,
                ':cliente_id'    => $cliente_id,
                ':data_prevista' => $data_devolucao_prevista
            ]);
            if ($sucesso) {
                Filme::alterarStatus($filme_id, 'alugado');
            }
            $conn->commit();
            return $sucesso;
        } catch (\PDOException $e) {
            if ($conn->inTransaction()) $conn->rollBack();
            throw $e;
        }
    }

    public static function devolver($id, $filme_id) 
    {
        $conn = Database::getConnection();
        try {
            $conn->beginTransaction();
            $stmt = $conn->prepare("UPDATE locacoes SET status = 'concluida', data_devolucao_real = NOW() WHERE id = :id");
            $sucesso = $stmt->execute([':id' => $id]);
            if ($sucesso) {
                Filme::alterarStatus($filme_id, 'disponivel');
            }
            $conn->commit();
            return $sucesso;
        } catch (\PDOException $e) {
            if ($conn->inTransaction()) $conn->rollBack();
            throw $e;
        }
    }
}