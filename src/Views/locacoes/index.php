<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MovieLoc - Gerenciamento de Locações</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light">

    <!-- Navbar Padronizada -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4 text-white" href="index.php">
                🎬 MovieLoc
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto ms-lg-4">
                    <li class="nav-item">
                        <a class="nav-link text-white-50" href="index.php?page=filmes">Filmes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white-50" href="index.php?page=clientes">Clientes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white fw-bold" href="index.php?page=locacoes">Locações</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    <span class="text-light small">Olá, <strong><?= htmlspecialchars($_SESSION['usuario']['nome'] ?? '') ?></strong></span>
                    <a href="index.php?page=logout" class="btn btn-outline-danger btn-sm px-3">Sair</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container my-4">
        <!-- Título com Ícone de Claquete -->
        <h1 class="mb-4 text-center fw-bold text-primary display-5">🎬 MovieLoc - Gerenciamento de Locações</h1>

        <!-- Formulário com Cabeçalho Azul -->
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-header bg-primary text-white fw-bold py-3 fs-5">
                Registrar Nova Locação
            </div>
            <div class="card-body p-4">
                <form action="index.php?page=locacoes&action=cadastrar" method="POST" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Filme (Disponíveis)</label>
                        <select name="filme_id" class="form-select" required>
                            <option value="">Selecione um filme...</option>
                            <?php if (!empty($filmesDisponiveis)): ?>
                                <?php foreach ($filmesDisponiveis as $filme): ?>
                                    <option value="<?= $filme['id'] ?>"><?= htmlspecialchars($filme['titulo']) ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Cliente</label>
                        <select name="cliente_id" class="form-select" required>
                            <option value="">Selecione um cliente...</option>
                            <?php if (!empty($clientes)): ?>
                                <?php foreach ($clientes as $cliente): ?>
                                    <option value="<?= $cliente['id'] ?>"><?= htmlspecialchars($cliente['nome']) ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Devolução Prevista</label>
                        <input type="date" name="data_devolucao_prevista" class="form-control" required value="<?= date('Y-m-d', strtotime('+3 days')) ?>">
                    </div>
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-success px-4 fw-semibold">
                            Confirmar Locação
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabela Escura Padronizada -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-secondary text-white fw-bold py-3 fs-5">
                Histórico de Locações
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th class="ps-3">ID</th>
                                <th>Filme</th>
                                <th>Cliente</th>
                                <th>Data Locação</th>
                                <th>Devolução Prevista</th>
                                <th>Status</th>
                                <th class="text-end pe-3">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($locacoes)): ?>
                                <?php foreach ($locacoes as $locacao): ?>
                                    <tr>
                                        <td class="ps-3 fw-bold text-secondary">#<?= $locacao['id'] ?></td>
                                        <td class="fw-semibold"><?= htmlspecialchars($locacao['filme_titulo'] ?? '') ?></td>
                                        <td><?= htmlspecialchars($locacao['cliente_nome'] ?? '') ?></td>
                                        <td><?= date('d/m/Y H:i', strtotime($locacao['data_locacao'])) ?></td>
                                        <td><?= date('d/m/Y', strtotime($locacao['data_devolucao_prevista'])) ?></td>
                                        <td>
                                            <?php if (($locacao['status'] ?? '') === 'Devolvido'): ?>
                                                <span class="badge bg-success">Devolvido</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Em Aberto</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-end pe-3">
                                            <?php if (($locacao['status'] ?? '') !== 'Devolvido'): ?>
                                                <a href="index.php?page=locacoes&action=devolver&id=<?= $locacao['id'] ?>" class="btn btn-success btn-sm fw-semibold">
                                                    Registrar Devolução
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">Nenhuma locação registrada.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Script JS Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>