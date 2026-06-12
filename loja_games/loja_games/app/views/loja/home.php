<?php require __DIR__.'/../partials/header.php'; ?>
<?php require __DIR__.'/../partials/navbar.php'; ?>

<!-- HERO -->
<section class="hero">
  <div class="hero-bg">
    <div class="hero-grid"></div>
    <div class="hero-orb orb1"></div>
    <div class="hero-orb orb2"></div>
    <div class="hero-scan"></div>
  </div>
  <div class="hero-content">
    <div class="hero-badge">🎮 Nova temporada — jogos com até 60% OFF</div>
    <h1 class="hero-title">
      LEVEL UP<br>
      <span class="neon-text">SUA BIBLIOTECA</span>
    </h1>
    <p class="hero-sub">Os melhores títulos do mercado com os melhores preços. Compre, jogue, domine.</p>
    <div class="hero-btns">
      <a href="<?= BASE_URL ?>catalogo" class="btn-neon">Ver Catálogo</a>
      <?php if(!isset($_SESSION['uid'])): ?>
      <a href="<?= BASE_URL ?>cadastro" class="btn-ghost">Criar Conta</a>
      <?php endif; ?>
    </div>
  </div>
  <div class="hero-stats">
    <div class="hstat"><span><?= count($todos) ?>+</span><small>Jogos</small></div>
    <div class="hstat"><span>60%</span><small>OFF em promoções</small></div>
    <div class="hstat"><span>24h</span><small>Entrega digital</small></div>
  </div>
</section>

<?php require __DIR__.'/../partials/flash.php'; ?>

<!-- DESTAQUES -->
<section class="section">
  <div class="container">
    <div class="section-head">
      <h2 class="section-title"><span class="neon-text">◈</span> Destaques</h2>
      <a href="<?= BASE_URL ?>catalogo" class="see-all">Ver todos →</a>
    </div>
    <div class="games-grid featured">
      <?php foreach($destaques as $j): ?>
      <a href="<?= BASE_URL ?>jogo?slug=<?= $j['slug'] ?>" class="game-card">
        <div class="game-img-wrap">
          <?php if($j['imagem_url']): ?>
            <img src="<?= htmlspecialchars($j['imagem_url']) ?>" alt="<?= htmlspecialchars($j['nome']) ?>" loading="lazy" onerror="this.style.display='none'">
          <?php endif; ?>
          <div class="game-img-fallback"><?= mb_substr($j['nome'],0,2) ?></div>
          <?php if($j['preco_promocional']): ?>
            <div class="game-badge-sale">-<?= round((1-$j['preco_promocional']/$j['preco'])*100) ?>%</div>
          <?php endif; ?>
          <div class="game-overlay">
            <span class="game-platform"><?= htmlspecialchars($j['plataforma']) ?></span>
          </div>
        </div>
        <div class="game-info">
          <span class="game-cat"><?= htmlspecialchars($j['cat']??'') ?></span>
          <h3><?= htmlspecialchars($j['nome']) ?></h3>
          <p><?= htmlspecialchars($j['descricao_curta']??'') ?></p>
          <div class="game-price">
            <?php if($j['preco_promocional']): ?>
              <s>R$ <?= number_format($j['preco'],2,',','.') ?></s>
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

<!-- CATEGORIAS -->
<section class="section section-dark">
  <div class="container">
    <h2 class="section-title"><span class="neon-text">◈</span> Categorias</h2>
    <div class="cats-grid">
      <?php foreach($categorias as $c): ?>
      <a href="<?= BASE_URL ?>catalogo?cat=<?= $c['id'] ?>" class="cat-card">
        <span class="cat-icon"><?= $c['icone'] ?></span>
        <span><?= htmlspecialchars($c['nome']) ?></span>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- TODOS OS JOGOS -->
<section class="section">
  <div class="container">
    <div class="section-head">
      <h2 class="section-title"><span class="neon-text">◈</span> Todos os Jogos</h2>
      <a href="<?= BASE_URL ?>catalogo" class="see-all">Catálogo completo →</a>
    </div>
    <div class="games-grid">
      <?php foreach(array_slice($todos,0,8) as $j): ?>
      <a href="<?= BASE_URL ?>jogo?slug=<?= $j['slug'] ?>" class="game-card">
        <div class="game-img-wrap">
          <?php if($j['imagem_url']): ?>
            <img src="<?= htmlspecialchars($j['imagem_url']) ?>" alt="<?= htmlspecialchars($j['nome']) ?>" loading="lazy" onerror="this.style.display='none'">
          <?php endif; ?>
          <div class="game-img-fallback"><?= mb_substr($j['nome'],0,2) ?></div>
          <?php if($j['preco_promocional']): ?>
            <div class="game-badge-sale">OFERTA</div>
          <?php endif; ?>
        </div>
        <div class="game-info">
          <span class="game-cat"><?= htmlspecialchars($j['cat']??'') ?></span>
          <h3><?= htmlspecialchars($j['nome']) ?></h3>
          <div class="game-price">
            <?php if($j['preco_promocional']): ?>
              <s>R$ <?= number_format($j['preco'],2,',','.') ?></s>
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

<?php require __DIR__.'/../partials/footer.php'; ?>
