<?php

namespace App\Controllers;

use App\Models\Locacao;
use App\Models\Filme;
use App\Models\Cliente;

class LocacaoController 
{
    public function index() 
    {
        $locacoes = Locacao::listarTodas();
        
        // Buscar filmes disponíveis e todos os clientes para montar o formulário
        $allFilmes = Filme::listarTodos();
        $filmesDisponiveis = array_filter($allFilmes, function($f) {
            return $f['status'] === 'disponivel';
        });
        
        $clientes = Cliente::listarTodos();

        require_once __DIR__ . '/../Views/locacoes/index.php';
    }

    public function cadastrar() 
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $filme_id = $_POST['filme_id'] ?? null;
                $cliente_id = $_POST['cliente_id'] ?? null;
                $data_devolucao = $_POST['data_devolucao_prevista'] ?? null;

                if (empty($filme_id) || empty($cliente_id) || empty($data_devolucao)) {
                    throw new \InvalidArgumentException("Filme, cliente e data são obrigatórios.");
                }
                if (strtotime($data_devolucao) < strtotime(date('Y-m-d'))) {
                    throw new \InvalidArgumentException("Data de devolução não pode ser no passado.");
                }

                Locacao::salvar($filme_id, $cliente_id, $data_devolucao);
                header('Location: index.php?page=locacoes');
                exit;
            } catch (\PDOException $e) {
                die("Erro de banco ao registrar locação: " . htmlspecialchars($e->getMessage()));
            } catch (\InvalidArgumentException $e) {
                die("Erro de validação: " . htmlspecialchars($e->getMessage()));
            }
        }
    }

    public function devolver() 
    {
        try {
            $id = $_GET['id'] ?? null;
            $filme_id = $_GET['filme_id'] ?? null;

            if ($id && $filme_id) {
                Locacao::devolver($id, $filme_id);
            }
            header('Location: index.php?page=locacoes');
            exit;
        } catch (\PDOException $e) {
            die("Erro ao registrar devolução: " . htmlspecialchars($e->getMessage()));
        }
    }
}