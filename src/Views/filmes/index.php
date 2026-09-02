<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MovieLoc - Gerenciamento de Filmes</title>
    
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
                        <a class="nav-link text-white fw-bold" href="index.php?page=filmes">Filmes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white-50" href="index.php?page=clientes">Clientes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white-50" href="index.php?page=locacoes">Locações</a>
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
        <h1 class="mb-4 text-center fw-bold text-primary display-5">🎬 MovieLoc - Gerenciamento de Filmes</h1>

        <!-- Formulário com Cabeçalho Azul -->
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-header bg-primary text-white fw-bold py-3 fs-5">
                Cadastrar Novo Filme
            </div>
            <div class="card-body p-4">
                <form action="index.php?page=filmes&action=cadastrar" method="POST" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Título</label>
                        <input type="text" name="titulo" class="form-control" required placeholder="Ex: Matrix">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Gênero</label>
                        <input type="text" name="genero" class="form-control" required placeholder="Ex: Ação">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Ano</label>
                        <input type="number" name="ano" class="form-control" required placeholder="1999" min="1900" max="<?= date('Y') ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Preço Locação (R$)</label>
                        <input type="number" step="0.01" name="preco" class="form-control" required placeholder="9.90">
                    </div>
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-success px-4 fw-semibold">
                            Salvar Filme
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabela Escura Padronizada -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-secondary text-white fw-bold py-3 fs-5">
                Filmes Cadastrados
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th class="ps-3">ID</th>
                                <th>Título</th>
                                <th>Gênero</th>
                                <th>Ano</th>
                                <th>Preço</th>
                                <th>Status</th>
                                <th class="text-end pe-3">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($filmes)): ?>
                                <?php foreach ($filmes as $filme): ?>
                                    <?php 
                                        // Garante leitura das colunas independentemente do nome exato na tabela do banco
                                        $ano = $filme['ano'] ?? $filme['ano_lancamento'] ?? '-';
                                        $preco = $filme['preco'] ?? $filme['preco_locacao'] ?? $filme['valor'] ?? 0;
                                    ?>
                                    <tr>
                                        <td class="ps-3 fw-bold text-secondary">#<?= $filme['id'] ?></td>
                                        <td class="fw-semibold"><?= htmlspecialchars($filme['titulo']) ?></td>
                                        <td><?= htmlspecialchars($filme['genero']) ?></td>
                                        <td><?= htmlspecialchars($ano) ?></td>
                                        <td>R$ <?= number_format((float)$preco, 2, ',', '.') ?></td>
                                        <td>
                                            <?php if (($filme['status'] ?? '') === 'Alugado'): ?>
                                                <span class="badge bg-warning text-dark">Alugado</span>
                                            <?php else: ?>
                                                <span class="badge bg-success">Disponível</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-end pe-3">
                                            <a href="index.php?page=filmes&action=excluir&id=<?= $filme['id'] ?>" class="btn btn-danger btn-sm fw-semibold" onclick="return confirm('Deseja realmente excluir este filme?')">
                                                Excluir
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">Nenhum filme cadastrado.</td>
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