<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MovieLoc - Registro de Locações</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <!-- Navbar de Navegação -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">🎬 MovieLoc</a>
        <div class="navbar-nav me-auto">
            <a class="nav-link" href="index.php?page=filmes">Filmes</a>
            <a class="nav-link" href="index.php?page=clientes">Clientes</a>
            <a class="nav-link active" href="index.php?page=locacoes">Locações</a>
        </div>
        <div class="navbar-nav">
            <span class="nav-link text-light me-2">Olá, <?= htmlspecialchars($_SESSION['usuario']['nome'] ?? '') ?></span>
            <a class="btn btn-outline-danger btn-sm" href="index.php?page=logout">Sair</a>
        </div>
    </div>
</nav>

    <div class="container my-4">
        <h1 class="mb-4 text-center text-primary">📑 MovieLoc - Gerenciamento de Locações</h1>

        <div class="card mb-5 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Registrar Nova Locação</h5>
            </div>
            <div class="card-body">
                <form action="index.php?page=locacoes&action=cadastrar" method="POST" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Filme (Disponíveis)</label>
                        <select name="filme_id" class="form-select" required>
                            <option value="">Selecione um filme...</option>
                            <?php foreach ($filmesDisponiveis as $filme): ?>
                                <option value="<?= $filme['id'] ?>">
                                    <?= htmlspecialchars($filme['titulo']) ?> (R$ <?= number_format($filme['preco_locacao'], 2, ',', '.') ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Cliente</label>
                        <select name="cliente_id" class="form-select" required>
                            <option value="">Selecione um cliente...</option>
                            <?php foreach ($clientes as $cliente): ?>
                                <option value="<?= $cliente['id'] ?>">
                                    <?= htmlspecialchars($cliente['nome']) ?> (CPF: <?= htmlspecialchars($cliente['cpf']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Devolução Prevista</label>
                        <input type="date" name="data_devolucao_prevista" class="form-control" required value="<?= date('Y-m-d', strtotime('+3 days')) ?>">
                    </div>

                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-success" <?= empty($filmesDisponiveis) ? 'disabled' : '' ?>>
                            <?= empty($filmesDisponiveis) ? 'Nenhum filme disponível' : 'Confirmar Locação' ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0">Histórico de Locações</h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Filme</th>
                            <th>Cliente</th>
                            <th>Data Locação</th>
                            <th>Devolução Prevista</th>
                            <th>Status</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($locacoes)): ?>
                            <tr>
                                <td colspan="7" class="text-center py-3">Nenhuma locação registrada ainda.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($locacoes as $loc): ?>
                                <tr>
                                    <td><?= $loc['id'] ?></td>
                                    <td><?= htmlspecialchars($loc['filme_titulo']) ?></td>
                                    <td><?= htmlspecialchars($loc['cliente_nome']) ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($loc['data_locacao'])) ?></td>
                                    <td><?= date('d/m/Y', strtotime($loc['data_devolucao_prevista'])) ?></td>
                                    <td>
                                        <span class="badge bg-<?= $loc['status'] === 'ativa' ? 'danger' : 'success' ?>">
                                            <?= $loc['status'] === 'ativa' ? 'Em Aberto' : 'Devolvido' ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($loc['status'] === 'ativa'): ?>
                                            <a href="index.php?page=locacoes&action=devolver&id=<?= $loc['id'] ?>&filme_id=<?= $loc['filme_id'] ?>" 
                                               class="btn btn-sm btn-success"
                                               onclick="return confirm('Confirmar a devolução deste filme?')">
                                               Registrar Devolução
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted small">Finalizada em <?= date('d/m/Y H:i', strtotime($loc['data_devolucao_real'])) ?></span>
                                        <?php endif; ?>
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