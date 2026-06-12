<?php require __DIR__.'/../partials/header.php'; ?>
<?php require __DIR__.'/../partials/navbar.php'; ?>

<div class="page-banner">
  <div class="container"><h1>🛒 Meu Carrinho</h1></div>
</div>

<section class="section">
  <div class="container">
    <?php require __DIR__.'/../partials/flash.php'; ?>

    <?php if(empty($itens)): ?>
    <div class="empty-state">
      <span>🛒</span>
      <p>Seu carrinho está vazio.</p>
      <a href="<?= BASE_URL ?>catalogo" class="btn-neon">Explorar Jogos</a>
    </div>
    <?php else: ?>
    <div class="cart-layout">
      <div class="cart-items">
        <?php foreach($itens as $i): $preco=$i['preco_promocional']??$i['preco']; ?>
        <div class="cart-item">
          <div class="cart-img">
            <?php if($i['imagem_url']): ?>
              <img src="<?= htmlspecialchars($i['imagem_url']) ?>" alt="" onerror="this.style.display='none'">
            <?php endif; ?>
            <div class="cart-img-fallback"><?= mb_substr($i['nome'],0,2) ?></div>
          </div>
          <div class="cart-item-info">
            <h3><?= htmlspecialchars($i['nome']) ?></h3>
            <span class="cart-plat"><?= htmlspecialchars($i['plataforma']) ?></span>
            <div class="cart-item-price">
              <?php if($i['preco_promocional']): ?>
                <s>R$ <?= number_format($i['preco'],2,',','.') ?></s>
                <strong class="neon-price">R$ <?= number_format($i['preco_promocional'],2,',','.') ?></strong>
              <?php else: ?>
                <strong>R$ <?= number_format($i['preco'],2,',','.') ?></strong>
              <?php endif; ?>
            </div>
          </div>
          <div class="cart-item-qty">
            <span>Qtd: <?= $i['quantidade'] ?></span>
            <strong>R$ <?= number_format($preco*$i['quantidade'],2,',','.') ?></strong>
          </div>
          <form method="POST" action="<?= BASE_URL ?>carrinho/remover" class="cart-remove">
            <input type="hidden" name="csrf" value="<?= $csrf ?>">
            <input type="hidden" name="jogo_id" value="<?= $i['jogo_id'] ?>">
            <button type="submit" title="Remover">✕</button>
          </form>
        </div>
        <?php endforeach; ?>
      </div>

      <div class="cart-summary">
        <h3>Resumo</h3>
        <div class="summary-row"><span>Subtotal</span><span>R$ <?= number_format($total,2,',','.') ?></span></div>
        <div class="summary-row"><span>Frete</span><span class="neon-text">GRÁTIS</span></div>
        <div class="summary-row total"><span>Total</span><strong class="neon-text">R$ <?= number_format($total,2,',','.') ?></strong></div>
        <form method="POST" action="<?= BASE_URL ?>carrinho/finalizar" onsubmit="return confirm('Confirmar pedido?')">
          <input type="hidden" name="csrf" value="<?= $csrf ?>">
          <button type="submit" class="btn-neon full">✔ Finalizar Compra</button>
        </form>
        <a href="<?= BASE_URL ?>catalogo" class="btn-ghost full mt">Continuar Comprando</a>
      </div>
    </div>
    <?php endif; ?>
  </div>
</section>

<?php require __DIR__.'/../partials/footer.php'; ?>
