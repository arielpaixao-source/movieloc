<?php

namespace App\Controllers;

use App\Models\Cliente;

class ClienteController 
{
    public function index() 
    {
        $clientes = Cliente::listarTodos();
        $clienteEdicao = null;

        if (isset($_GET['editar_id'])) {
            $clienteEdicao = Cliente::buscarPorId($_GET['editar_id']);
        }

        require_once __DIR__ . '/../Views/clientes/index.php';
    }

    public function cadastrar() 
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $nome = $_POST['nome'] ?? '';
            $cpf = $_POST['cpf'] ?? '';
            $telefone = $_POST['telefone'] ?? '';
            $email = $_POST['email'] ?? '';

            if (!empty($nome) && !empty($cpf)) {
                if ($id) {
                    Cliente::atualizar($id, $nome, $cpf, $telefone, $email);
                } else {
                    Cliente::salvar($nome, $cpf, $telefone, $email);
                }
            }
            header('Location: index.php?page=clientes');
            exit;
        }
    }

    public function excluir() 
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            Cliente::excluir($id);
        }
        header('Location: index.php?page=clientes');
        exit;
    }
}