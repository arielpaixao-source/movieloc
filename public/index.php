<?php

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\FilmeController;
use App\Controllers\ClienteController;
use App\Controllers\LocacaoController;
use App\Controllers\AuthController;

$page = $_GET['page'] ?? 'filmes';
$action = $_GET['action'] ?? 'index';

// Rotas públicas (não exigem login)
if ($page === 'login') {
    (new AuthController())->login();
    exit;
} elseif ($page === 'registrar') {
    (new AuthController())->registrar();
    exit;
} elseif ($page === 'logout') {
    (new AuthController())->logout();
    exit;
}

// Trava de segurança: Se não estiver logado, redireciona para a tela de Login
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php?page=login');
    exit;
}

// Rotas protegidas (exigem login)
if ($page === 'clientes') {
    $controller = new ClienteController();
    if ($action === 'cadastrar') $controller->cadastrar();
    elseif ($action === 'excluir') $controller->excluir();
    else $controller->index();
} elseif ($page === 'locacoes') {
    $controller = new LocacaoController();
    if ($action === 'cadastrar') $controller->cadastrar();
    elseif ($action === 'devolver') $controller->devolver();
    else $controller->index();
} else {
    $controller = new FilmeController();
    if ($action === 'cadastrar') $controller->cadastrar();
    elseif ($action === 'status') $controller->alternarStatus();
    elseif ($action === 'excluir') $controller->excluir();
    else $controller->index();
}