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
            $id = $_POST['id'] ?? null;
            $titulo = $_POST['titulo'] ?? '';
            $genero = $_POST['genero'] ?? '';
            $ano = $_POST['ano_lancamento'] ?? 0;
            $preco = $_POST['preco_locacao'] ?? 0;

            if (!empty($titulo) && !empty($genero)) {
                if ($id) {
                    Filme::atualizar($id, $titulo, $genero, $ano, $preco);
                } else {
                    Filme::salvar($titulo, $genero, $ano, $preco);
                }
            }
            header('Location: index.php');
            exit;
        }
    }

    public function alternarStatus() 
    {
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
    }

    public function excluir() 
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            Filme::excluir($id);
        }
        header('Location: index.php');
        exit;
    }
}