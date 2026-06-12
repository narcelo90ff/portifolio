<?php require_once 'View/navbar.php'; ?>

<div class="gs-page-header">
    <h1>Categorias</h1>
</div>

<div class="gs-grid">
    <?php foreach($categorias as $categoria): ?>
        <div class="card">
            <p><?= htmlspecialchars($categoria['nome']) ?></p>
        </div>
    <?php endforeach; ?>
</div>
