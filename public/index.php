<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\FilmeController;
use App\Controllers\ClienteController;
use App\Controllers\LocacaoController;

$page = $_GET['page'] ?? 'filmes';
$action = $_GET['action'] ?? 'index';

if ($page === 'clientes') {
    $controller = new ClienteController();
    if ($action === 'cadastrar') {
        $controller->cadastrar();
    } elseif ($action === 'excluir') {
        $controller->excluir();
    } else {
        $controller->index();
    }
} elseif ($page === 'locacoes') {
    $controller = new LocacaoController();
    if ($action === 'cadastrar') {
        $controller->cadastrar();
    } elseif ($action === 'devolver') {
        $controller->devolver();
    } else {
        $controller->index();
    }
} else {
    $controller = new FilmeController();
    if ($action === 'cadastrar') {
        $controller->cadastrar();
    } elseif ($action === 'status') {
        $controller->alternarStatus();
    } elseif ($action === 'excluir') {
        $controller->excluir();
    } else {
        $controller->index();
    }
}