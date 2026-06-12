<?php require_once 'View/navbar.php'; ?>

<?php $carrinho = $carrinho ?? []; ?>

<div class="gs-page-header">
    <div>
        <h1>🛒 Meu Carrinho</h1>
        <p>Jogos adicionados para compra</p>
    </div>
</div>

<?php if(empty($carrinho)): ?>

    <div class="card">
        <h3>Seu carrinho está vazio</h3>
        <p>Explore o catálogo e adicione jogos ao seu carrinho.</p>

        <a href="index.php?p=catalogo" class="botao">
            Ir para Catálogo
        </a>
    </div>

<?php else: ?>

    <div class="gs-grid">

        <?php
            $total = 0;
            foreach($carrinho as $jogo):
            $total += $jogo['preco'];
        ?>

            <div class="card">

                <h3><?= $jogo['titulo'] ?></h3>

                <p><?= $jogo['descricao'] ?></p>

                <p class="gs-price">
                    R$ <?= number_format($jogo['preco'], 2, ',', '.') ?>
                </p>

                <a href="index.php?p=remover-carrinho&id=<?= $jogo['id'] ?>" class="btn btn-danger">
                    🗑 Remover
                </a>

            </div>

        <?php endforeach; ?>

    </div>

    <div class="card" style="margin-top:20px; text-align:center;">

    <h3>💳 Resumo da Compra</h3>

    <div class="resumo-linha">
        <span>Itens</span>
        <span><?= count($carrinho) ?></span>
    </div>

    <div class="resumo-linha">
        <span>Total</span>
        <span class="gs-price">
            R$ <?= number_format($total, 2, ',', '.') ?>
        </span>
    </div>

    <hr>

    <a href="#" class="botao botao-principal">
        Finalizar Compra
    </a>

    <a href="index.php?p=catalogo" class="btn btn-ghost" style="width:100%; margin-top:10px;">
        Continuar Comprando
    </a>

</div>

    </div>

<?php endif; ?>

<?php require_once 'View/layout-footer.php'; ?>