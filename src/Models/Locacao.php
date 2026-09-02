<?php

namespace App\Models;

use Config\Database;
use PDO;

class Locacao 
{
    public static function listarTodas() 
    {
        $conn = Database::getConnection();
        $query = "SELECT l.*, f.titulo as filme_titulo, c.nome as cliente_nome 
                  FROM locacoes l
                  JOIN filmes f ON l.filme_id = f.id
                  JOIN clientes c ON l.cliente_id = c.id
                  ORDER BY l.id DESC";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function salvar($filme_id, $cliente_id, $data_devolucao_prevista) 
    {
        $conn = Database::getConnection();
        
        // 1. Inserir a locação
        $stmt = $conn->prepare("INSERT INTO locacoes (filme_id, cliente_id, data_devolucao_prevista) VALUES (:filme_id, :cliente_id, :data_prevista)");
        $sucesso = $stmt->execute([
            ':filme_id'      => $filme_id,
            ':cliente_id'    => $cliente_id,
            ':data_prevista' => $data_devolucao_prevista
        ]);

        // 2. Atualizar status do filme para 'alugado'
        if ($sucesso) {
            Filme::alterarStatus($filme_id, 'alugado');
        }

        return $sucesso;
    }

    public static function devolver($id, $filme_id) 
    {
        $conn = Database::getConnection();
        
        // 1. Atualizar locação para concluída
        $stmt = $conn->prepare("UPDATE locacoes SET status = 'concluida', data_devolucao_real = NOW() WHERE id = :id");
        $sucesso = $stmt->execute([':id' => $id]);

        // 2. Voltar status do filme para 'disponivel'
        if ($sucesso) {
            Filme::alterarStatus($filme_id, 'disponivel');
        }

        return $sucesso;
    }
}