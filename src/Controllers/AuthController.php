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
            $email = $_POST['email'] ?? '';
            $senha = $_POST['senha'] ?? '';

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
            $nome  = $_POST['nome'] ?? '';
            $email = $_POST['email'] ?? '';
            $senha = $_POST['senha'] ?? '';

            if (!empty($nome) && !empty($email) && !empty($senha)) {
                if (Usuario::buscarPorEmail($email)) {
                    $erro = "Este e-mail já está cadastrado.";
                } else {
                    Usuario::cadastrar($nome, $email, $senha);
                    header('Location: index.php?page=login&sucesso=1');
                    exit;
                }
            } else {
                $erro = "Preencha todos os campos.";
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
