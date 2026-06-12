<?php require __DIR__.'/../partials/header.php'; ?>
<?php require __DIR__.'/../partials/navbar.php'; ?>

<section class="jogo-detail">
  <div class="container">
    <?php require __DIR__.'/../partials/flash.php'; ?>
    <div class="jogo-layout">

      <!-- Imagem -->
      <div class="jogo-cover">
        <?php if($jogo['imagem_url']): ?>
          <img src="<?= htmlspecialchars($jogo['imagem_url']) ?>" alt="<?= htmlspecialchars($jogo['nome']) ?>" onerror="this.style.display='none'">
        <?php endif; ?>
        <div class="jogo-cover-fallback"><?= mb_substr($jogo['nome'],0,2) ?></div>
        <?php if($jogo['preco_promocional']): ?>
          <div class="jogo-badge-sale">-<?= round((1-$jogo['preco_promocional']/$jogo['preco'])*100) ?>% OFF</div>
        <?php endif; ?>
      </div>

      <!-- Info -->
      <div class="jogo-info">
        <div class="jogo-meta">
          <span class="jogo-cat"><?= htmlspecialchars($jogo['cat']??'') ?></span>
          <span class="jogo-plat"><?= htmlspecialchars($jogo['plataforma']) ?></span>
        </div>
        <h1 class="jogo-title"><?= htmlspecialchars($jogo['nome']) ?></h1>
        <p class="jogo-short"><?= htmlspecialchars($jogo['descricao_curta']??'') ?></p>
        <p class="jogo-desc"><?= nl2br(htmlspecialchars($jogo['descricao']??'')) ?></p>

        <div class="jogo-price-box">
          <?php if($jogo['preco_promocional']): ?>
            <div class="jogo-old-price">R$ <?= number_format($jogo['preco'],2,',','.') ?></div>
            <div class="jogo-new-price neon-text">R$ <?= number_format($jogo['preco_promocional'],2,',','.') ?></div>
          <?php else: ?>
            <div class="jogo-new-price neon-text">R$ <?= number_format($jogo['preco'],2,',','.') ?></div>
          <?php endif; ?>
        </div>

        <?php if(isset($_SESSION['uid'])): ?>
        <form method="POST" action="<?= BASE_URL ?>carrinho/adicionar">
          <input type="hidden" name="csrf" value="<?= $csrf ?>">
          <input type="hidden" name="jogo_id" value="<?= $jogo['id'] ?>">
          <button type="submit" class="btn-neon full">🛒 Adicionar ao Carrinho</button>
        </form>
        <?php else: ?>
        <a href="<?= BASE_URL ?>login" class="btn-neon full">🔐 Faça login para comprar</a>
        <?php endif; ?>

        <div class="jogo-tags">
          <span>✔ Entrega digital imediata</span>
          <span>✔ Pagamento seguro</span>
          <span>✔ Suporte 24h</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Relacionados -->
<?php if(!empty($relacionados)): ?>
<section class="section">
  <div class="container">
    <h2 class="section-title"><span class="neon-text">◈</span> Jogos Relacionados</h2>
    <div class="games-grid">
      <?php foreach($relacionados as $j): ?>
      <a href="<?= BASE_URL ?>jogo?slug=<?= $j['slug'] ?>" class="game-card">
        <div class="game-img-wrap">
          <?php if($j['imagem_url']): ?>
            <img src="<?= htmlspecialchars($j['imagem_url']) ?>" alt="<?= htmlspecialchars($j['nome']) ?>" loading="lazy" onerror="this.style.display='none'">
          <?php endif; ?>
          <div class="game-img-fallback"><?= mb_substr($j['nome'],0,2) ?></div>
        </div>
        <div class="game-info">
          <h3><?= htmlspecialchars($j['nome']) ?></h3>
          <div class="game-price">
            <?php if($j['preco_promocional']): ?>
              <strong class="neon-price">R$ <?= number_format($j['preco_promocional'],2,',','.') ?></strong>
            <?php else: ?>
              <strong>R$ <?= number_format($j['preco'],2,',','.') ?></strong>
            <?php endif; ?>
          </div>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php require __DIR__.'/../partials/footer.php'; ?>
