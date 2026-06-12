<?php

require_once 'View/navbar.php';
require_once 'Model/Usuario.php';
require_once 'Model/Jogo.php';
require_once 'Model/Categoria.php';

?>

<div class="gs-page-header">
    <div>
        <h1>🎮 Dashboard Admin</h1>
        <p>Bem-vindo, <?= htmlspecialchars($_SESSION['usuario']['nome']) ?> 👋</p>
    </div>
</div>

<div class="gs-stats">

    <div class="gs-stat-card">
        <div class="stat-num"><?= Usuario::total() ?></div>
        <div class="stat-label">Usuários</div>
    </div>

    <div class="gs-stat-card">
        <div class="stat-num"><?= Jogo::total() ?></div>
        <div class="stat-label">Jogos</div>
    </div>

    <div class="gs-stat-card">
        <div class="stat-num"><?= Categoria::total() ?></div>
        <div class="stat-label">Categorias</div>
    </div>

</div>

<!-- BLOCO DE BOAS-VINDAS -->
<div class="card admin-panel">

    <h3>⚙️ Painel Administrativo</h3>
    <p>Acesse e gerencie os CRUDs da GameStore</p>

    <div class="admin-grid">

        <a href="index.php?p=jogos" class="admin-btn">
            🎮 Jogos
        </a>

        <a href="index.php?p=categorias" class="admin-btn">
            🗂 Categorias
        </a>

        <a href="index.php?p=usuarios" class="admin-btn">
            👤 Usuários
        </a>

    </div>

</div>

<!-- ÚLTIMO LOGIN -->
<?php if(isset($_COOKIE['ultimo_login'])): ?>
    <div class="card">

        <h3>🕒 Último acesso</h3>

        <p><?= htmlspecialchars($_COOKIE['ultimo_login']) ?></p>

    </div>
<?php endif; ?>

<?php require_once 'View/layout-footer.php'; ?>