<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MovieLoc - Locadora de Filmes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <!-- Navbar de Navegação -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">🎬 MovieLoc</a>
        <div class="navbar-nav me-auto">
            <a class="nav-link active" href="index.php?page=filmes">Filmes</a>
            <a class="nav-link" href="index.php?page=clientes">Clientes</a>
            <a class="nav-link" href="index.php?page=locacoes">Locações</a>
        </div>
        <div class="navbar-nav">
            <span class="nav-link text-light me-2">Olá, <?= htmlspecialchars($_SESSION['usuario']['nome'] ?? '') ?></span>
            <a class="btn btn-outline-danger btn-sm" href="index.php?page=logout">Sair</a>
        </div>
    </div>
</nav>

    </nav>

    <div class="container my-4">
        <h1 class="mb-4 text-center text-primary">🎬 MovieLoc - Gerenciamento de Filmes</h1>

        <div class="card mb-5 shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><?= isset($filmeEdicao) ? 'Editar Filme' : 'Cadastrar Novo Filme' ?></h5>
                <?php if (isset($filmeEdicao)): ?>
                    <a href="index.php?page=filmes" class="btn btn-sm btn-light">Cancelar Edição</a>
                <?php endif; ?>
            </div>
            <div class="card-body">
                <form action="index.php?page=filmes&action=cadastrar" method="POST" class="row g-3">
                    <?php if (isset($filmeEdicao)): ?>
                        <input type="hidden" name="id" value="<?= $filmeEdicao['id'] ?>">
                    <?php endif; ?>

                    <div class="col-md-4">
                        <label class="form-label">Título</label>
                        <input type="text" name="titulo" class="form-control" required placeholder="Ex: Matrix" value="<?= $filmeEdicao['titulo'] ?? '' ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Gênero</label>
                        <input type="text" name="genero" class="form-control" required placeholder="Ex: Ação" value="<?= $filmeEdicao['genero'] ?? '' ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Ano</label>
                        <input type="number" name="ano_lancamento" class="form-control" required placeholder="1999" value="<?= $filmeEdicao['ano_lancamento'] ?? '' ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Preço Locação (R$)</label>
                        <input type="number" step="0.01" name="preco_locacao" class="form-control" required placeholder="9.90" value="<?= $filmeEdicao['preco_locacao'] ?? '' ?>">
                    </div>
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-<?= isset($filmeEdicao) ? 'warning' : 'success' ?>">
                            <?= isset($filmeEdicao) ? 'Atualizar Filme' : 'Salvar Filme' ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0">Filmes Cadastrados</h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Gênero</th>
                            <th>Ano</th>
                            <th>Preço</th>
                            <th>Status</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($filmes)): ?>
                            <tr>
                                <td colspan="7" class="text-center py-3">Nenhum filme cadastrado ainda.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($filmes as $filme): ?>
                                <tr>
                                    <td><?= $filme['id'] ?></td>
                                    <td><?= htmlspecialchars($filme['titulo']) ?></td>
                                    <td><?= htmlspecialchars($filme['genero']) ?></td>
                                    <td><?= $filme['ano_lancamento'] ?></td>
                                    <td>R$ <?= number_format($filme['preco_locacao'], 2, ',', '.') ?></td>
                                    <td>
                                        <span class="badge bg-<?= $filme['status'] === 'disponivel' ? 'success' : 'warning' ?>">
                                            <?= ucfirst($filme['status']) ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="index.php?page=filmes&action=status&id=<?= $filme['id'] ?>" 
                                           class="btn btn-sm btn-<?= $filme['status'] === 'disponivel' ? 'info text-white' : 'secondary' ?> me-1">
                                           <?= $filme['status'] === 'disponivel' ? 'Alugar' : 'Devolver' ?>
                                        </a>
                                        <a href="index.php?page=filmes&editar_id=<?= $filme['id'] ?>" class="btn btn-sm btn-warning me-1">Editar</a>
                                        <a href="index.php?page=filmes&action=excluir&id=<?= $filme['id'] ?>" 
                                           class="btn btn-sm btn-danger" 
                                           onclick="return confirm('Tem certeza que deseja excluir este filme?')">
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