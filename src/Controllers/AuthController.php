<?php

namespace App\Controllers;

use App\Models\Usuario;

class AuthController 
{
    public function login() 
    {
        if (isset($_SESSION['usuario'])) {
            header('Location: index.php?page=filmes');
            exit;
        }

        $erro = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $email = trim($_POST['email'] ?? '');
                $senha = $_POST['senha'] ?? '';

                if (empty($email) || empty($senha)) {
                    $erro = "Preencha e-mail e senha.";
                } else {
                    $usuario = Usuario::buscarPorEmail($email);
                    if ($usuario && password_verify($senha, $usuario['senha'])) {
                        $_SESSION['usuario'] = [
                            'id'    => $usuario['id'],
                            'nome'  => $usuario['nome'],
                            'email' => $usuario['email']
                        ];
                        header('Location: index.php?page=filmes');
                        exit;
                    } else {
                        $erro = "E-mail ou senha inválidos.";
                    }
                }
            } catch (\PDOException $e) {
                $erro = "Erro de banco: " . htmlspecialchars($e->getMessage());
            }
        }

        require_once __DIR__ . '/../Views/auth/login.php';
    }

    public function registrar() 
    {
        if (isset($_SESSION['usuario'])) {
            header('Location: index.php?page=filmes');
            exit;
        }

        $erro = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $nome  = trim($_POST['nome'] ?? '');
                $email = trim($_POST['email'] ?? '');
                $senha = $_POST['senha'] ?? '';

                if (empty($nome) || empty($email) || empty($senha)) {
                    $erro = "Preencha todos os campos.";
                } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $erro = "E-mail inválido.";
                } elseif (strlen($senha) < 6) {
                    $erro = "Senha deve ter ao menos 6 caracteres.";
                } elseif (Usuario::buscarPorEmail($email)) {
                    $erro = "Este e-mail já está cadastrado.";
                } else {
                    Usuario::cadastrar($nome, $email, $senha);
                    header('Location: index.php?page=login&sucesso=1');
                    exit;
                }
            } catch (\PDOException $e) {
                $erro = "Erro de banco: " . htmlspecialchars($e->getMessage());
            }
        }

        require_once __DIR__ . '/../Views/auth/registrar.php';
    }

   public function logout() 
    {
        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
        header('Location: index.php?page=login');
        exit;
    }
}
