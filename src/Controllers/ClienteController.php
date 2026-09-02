<?php

namespace App\Controllers;

use App\Models\Cliente;

class ClienteController 
{
    public function index() 
    {
        $clientes = Cliente::listarTodos();
        require_once __DIR__ . '/../Views/clientes/index.php';
    }

    public function cadastrar() 
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = trim($_POST['nome'] ?? '');
            $cpf = preg_replace('/[^0-9]/', '', $_POST['cpf'] ?? '');
            $telefone = preg_replace('/[^0-9]/', '', $_POST['telefone'] ?? '');
            $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);

            // Validações no backend
            if (strlen($nome) < 3 || strlen($nome) > 60) {
                die("Erro: O nome deve ter entre 3 e 60 caracteres.");
            }

            if (strlen($cpf) !== 11) {
                die("Erro: O CPF deve conter exatamente 11 dígitos numéricos.");
            }

            if (strlen($telefone) < 10 || strlen($telefone) > 11) {
                die("Erro: O telefone deve conter 10 ou 11 dígitos numéricos.");
            }

            if (!$email || strlen($email) > 80) {
                die("Erro: Insira um endereço de e-mail válido.");
            }

            // Executa o cadastro com os dados protegidos
            Cliente::cadastrar($nome, $cpf, $telefone, $email);
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