<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MovieLoc - Gerenciamento de Clientes</title>
    
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
                        <a class="nav-link text-white fw-bold" href="index.php?page=clientes">Clientes</a>
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
        <h1 class="mb-4 text-center fw-bold text-primary display-5">🎬 MovieLoc - Gerenciamento de Clientes</h1>

        <!-- Formulário com Cabeçalho Azul -->
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-header bg-primary text-white fw-bold py-3 fs-5">
                Cadastrar Novo Cliente
            </div>
            <div class="card-body p-4">
                <form action="index.php?page=clientes&action=cadastrar" method="POST" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Nome Completo</label>
                        <input type="text" name="nome" class="form-control" maxlength="60" required placeholder="Ex: Ariel França">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">CPF (11 dígitos)</label>
                        <input type="text" name="cpf" class="form-control" maxlength="11" minlength="11" pattern="\d{11}" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required placeholder="Apenas números">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Telefone (DDD + Número)</label>
                        <input type="text" name="telefone" class="form-control" maxlength="11" minlength="10" pattern="\d{10,11}" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required placeholder="Ex: 71999998888">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">E-mail</label>
                        <input type="email" name="email" class="form-control" maxlength="80" required placeholder="nome@exemplo.com">
                    </div>
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-success px-4 fw-semibold">
                            Salvar Cliente
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabela Escura Padronizada -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-secondary text-white fw-bold py-3 fs-5">
                Clientes Cadastrados
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th class="ps-3">ID</th>
                                <th>Nome</th>
                                <th>CPF</th>
                                <th>Telefone</th>
                                <th>E-mail</th>
                                <th class="text-end pe-3">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($clientes)): ?>
                                <?php foreach ($clientes as $cliente): ?>
                                    <tr>
                                        <td class="ps-3 fw-bold text-secondary">#<?= $cliente['id'] ?></td>
                                        <td class="fw-semibold"><?= htmlspecialchars($cliente['nome']) ?></td>
                                        <td><?= htmlspecialchars($cliente['cpf']) ?></td>
                                        <td><?= htmlspecialchars($cliente['telefone']) ?></td>
                                        <td><?= htmlspecialchars($cliente['email']) ?></td>
                                        <td class="text-end pe-3">
                                            <a href="index.php?page=clientes&action=excluir&id=<?= $cliente['id'] ?>" class="btn btn-danger btn-sm fw-semibold" onclick="return confirm('Deseja realmente excluir este cliente?')">
                                                Excluir
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">Nenhum cliente cadastrado.</td>
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