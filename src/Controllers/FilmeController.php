<?php

namespace App\Controllers;

use App\Models\Filme;

class FilmeController 
{
    public function index() 
    {
        $filmes = Filme::listarTodos();
        $filmeEdicao = null;

        if (isset($_GET['editar_id'])) {
            $filmeEdicao = Filme::buscarPorId($_GET['editar_id']);
        }

        require_once __DIR__ . '/../Views/filmes/index.php';
    }

    public function cadastrar() 
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $id = $_POST['id'] ?? null;
                $titulo = trim($_POST['titulo'] ?? '');
                $genero = trim($_POST['genero'] ?? '');
                $ano = (int)($_POST['ano_lancamento'] ?? $_POST['ano'] ?? 0);
                $preco = (float)($_POST['preco_locacao'] ?? $_POST['preco'] ?? 0);

                if (empty($titulo) || empty($genero)) {
                    throw new \InvalidArgumentException("Título e gênero são obrigatórios.");
                }
                if ($ano < 1900 || $ano > (int)date('Y') + 1) {
                    throw new \InvalidArgumentException("Ano inválido.");
                }
                if ($preco <= 0) {
                    throw new \InvalidArgumentException("Preço deve ser maior que zero.");
                }

                if ($id) {
                    Filme::atualizar($id, $titulo, $genero, $ano, $preco);
                } else {
                    Filme::salvar($titulo, $genero, $ano, $preco);
                }
                header('Location: index.php');
                exit;
            } catch (\PDOException $e) {
                die("Erro de banco ao salvar filme: " . htmlspecialchars($e->getMessage()));
            } catch (\InvalidArgumentException $e) {
                die("Erro de validação: " . htmlspecialchars($e->getMessage()));
            }
        }
    }

    public function alternarStatus() 
    {
        try {
            $id = $_GET['id'] ?? null;
            if ($id) {
                $filme = Filme::buscarPorId($id);
                if ($filme) {
                    $novoStatus = ($filme['status'] === 'disponivel') ? 'alugado' : 'disponivel';
                    Filme::alterarStatus($id, $novoStatus);
                }
            }
            header('Location: index.php');
            exit;
        } catch (\PDOException $e) {
            die("Erro ao alterar status: " . htmlspecialchars($e->getMessage()));
        }
    }

    public function excluir() 
    {
        try {
            $id = $_GET['id'] ?? null;
            if ($id) {
                Filme::excluir($id);
            }
            header('Location: index.php');
            exit;
        } catch (\PDOException $e) {
            die("Erro ao excluir filme: " . htmlspecialchars($e->getMessage()));
        }
    }
}