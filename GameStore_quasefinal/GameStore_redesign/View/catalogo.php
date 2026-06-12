<?php require_once 'View/navbar.php'; ?>

<div class="gs-page-header">
    <h1>Catálogo de Jogos</h1>
</div>

<?php if(!empty($jogos)): ?>

    <div class="gs-grid">

        <?php foreach($jogos as $jogo): ?>

            <div class="card">

    <div style="border-radius:12px; overflow:hidden; margin-bottom:10px;">
        <img 
            src="public/img/<?= $jogo['imagem'] ?>" 
            alt="<?= $jogo['titulo'] ?>"
            style="width:100%; height:180px; object-fit:cover; display:block;"
        >
    </div>

    <h3><?= htmlspecialchars($jogo['titulo']) ?></h3>

    <p style="font-size:0.9rem;">
        <?= htmlspecialchars($jogo['descricao']) ?>
    </p>

    <p>
        <span class="badge badge-blue">
            <?= htmlspecialchars($jogo['categoria_nome']) ?>
        </span>
    </p>

    <p class="gs-price">
        R$ <?= number_format($jogo['preco'], 2, ',', '.') ?>
    </p>

    <div style="margin-top:1rem;">
        <?php if(isset($_SESSION['usuario'])): ?>
            <a href="index.php?p=adicionar-carrinho&id=<?= $jogo['id'] ?>" class="botao">
                🛒 Adicionar ao Carrinho
            </a>
        <?php else: ?>
            <a href="index.php?p=login" class="btn btn-ghost">
                Faça login
            </a>
        <?php endif; ?>
    </div>

</div>

        <?php endforeach; ?>

    </div>

<?php else: ?>

    <div class="card">
        <p>Nenhum jogo cadastrado.</p>
    </div>

<?php endif; ?>

<?php require_once 'View/layout-footer.php'; ?>
