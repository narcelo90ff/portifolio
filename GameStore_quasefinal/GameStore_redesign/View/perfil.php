<?php require_once 'View/navbar.php'; ?>

<div class="gs-page-header">
    <h1>Meu Perfil</h1>
</div>

<div class="card" style="max-width:480px; margin-bottom:1.5rem;">
    <p><strong>Nome:</strong> <?= htmlspecialchars($usuario['nome']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($usuario['email']) ?></p>
    <p><strong>Tipo:</strong>
        <span class="badge badge-blue"><?= htmlspecialchars($usuario['tipo']) ?></span>
    </p>
</div>

<h2 style="margin-bottom:1rem;">Minhas ações</h2>

<?php if($usuario['tipo'] === 'usuario'): ?>

    <div class="card" style="max-width:480px;">
        <p>🎮 Explore jogos do catálogo</p>
        <a href="index.php?p=catalogo" class="botao">Ver Catálogo</a>
    </div>

<?php endif; ?>

<?php if($usuario['tipo'] === 'admin'): ?>

    <div class="card" style="max-width:480px;">
        <h3>Painel Admin</h3>
        <div class="gs-actions" style="margin-top:.75rem;">
            <a href="index.php?p=jogos" class="botao">Jogos</a>
            <a href="index.php?p=categorias" class="botao">Categorias</a>
            <a href="index.php?p=usuarios" class="botao">Usuários</a>
        </div>
    </div>

<?php endif; ?>
