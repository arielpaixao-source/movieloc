<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MovieLoc - Gerenciamento de Clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <!-- Navbar de Navegação -->
   <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">🎬 MovieLoc</a>
        <div class="navbar-nav">
            <a class="nav-link" href="index.php?page=filmes">Filmes</a>
            <a class="nav-link active" href="index.php?page=clientes">Clientes</a>
            <a class="nav-link" href="index.php?page=locacoes">Locações</a>
        </div>
    </div>
</nav>

    <div class="container my-4">
        <h1 class="mb-4 text-center text-primary">👤 MovieLoc - Gerenciamento de Clientes</h1>

        <div class="card mb-5 shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><?= isset($clienteEdicao) ? 'Editar Cliente' : 'Cadastrar Novo Cliente' ?></h5>
                <?php if (isset($clienteEdicao)): ?>
                    <a href="index.php?page=clientes" class="btn btn-sm btn-light">Cancelar Edição</a>
                <?php endif; ?>
            </div>
            <div class="card-body">
                <form action="index.php?page=clientes&action=cadastrar" method="POST" class="row g-3">
                    <?php if (isset($clienteEdicao)): ?>
                        <input type="hidden" name="id" value="<?= $clienteEdicao['id'] ?>">
                    <?php endif; ?>

                    <div class="col-md-4">
                        <label class="form-label">Nome Completo</label>
                        <input type="text" name="nome" class="form-control" required placeholder="Ex: João Silva" value="<?= $clienteEdicao['nome'] ?? '' ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">CPF</label>
                        <input type="text" name="cpf" class="form-control" required placeholder="000.000.000-00" value="<?= $clienteEdicao['cpf'] ?? '' ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Telefone</label>
                        <input type="text" name="telefone" class="form-control" required placeholder="(71) 99999-9999" value="<?= $clienteEdicao['telefone'] ?? '' ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">E-mail</label>
                        <input type="email" name="email" class="form-control" placeholder="joao@email.com" value="<?= $clienteEdicao['email'] ?? '' ?>">
                    </div>
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-<?= isset($clienteEdicao) ? 'warning' : 'success' ?>">
                            <?= isset($clienteEdicao) ? 'Atualizar Cliente' : 'Salvar Cliente' ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0">Clientes Cadastrados</h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>CPF</th>
                            <th>Telefone</th>
                            <th>E-mail</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($clientes)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-3">Nenhum cliente cadastrado ainda.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($clientes as $cliente): ?>
                                <tr>
                                    <td><?= $cliente['id'] ?></td>
                                    <td><?= htmlspecialchars($cliente['nome']) ?></td>
                                    <td><?= htmlspecialchars($cliente['cpf']) ?></td>
                                    <td><?= htmlspecialchars($cliente['telefone']) ?></td>
                                    <td><?= htmlspecialchars($cliente['email'] ?? '-') ?></td>
                                    <td class="text-center">
                                        <a href="index.php?page=clientes&editar_id=<?= $cliente['id'] ?>" class="btn btn-sm btn-warning me-1">Editar</a>
                                        <a href="index.php?page=clientes&action=excluir&id=<?= $cliente['id'] ?>" 
                                           class="btn btn-sm btn-danger" 
                                           onclick="return confirm('Tem certeza que deseja excluir este cliente?')">
                                           Excluir
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>