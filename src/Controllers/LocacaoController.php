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
            $filme_id = $_POST['filme_id'] ?? null;
            $cliente_id = $_POST['cliente_id'] ?? null;
            $data_devolucao = $_POST['data_devolucao_prevista'] ?? null;

            if ($filme_id && $cliente_id && $data_devolucao) {
                Locacao::salvar($filme_id, $cliente_id, $data_devolucao);
            }
            header('Location: index.php?page=locacoes');
            exit;
        }
    }

    public function devolver() 
    {
        $id = $_GET['id'] ?? null;
        $filme_id = $_GET['filme_id'] ?? null;

        if ($id && $filme_id) {
            Locacao::devolver($id, $filme_id);
        }
        header('Location: index.php?page=locacoes');
        exit;
    }
}