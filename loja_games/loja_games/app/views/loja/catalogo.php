<?php require __DIR__.'/../partials/header.php'; ?>
<?php require __DIR__.'/../partials/navbar.php'; ?>

<div class="page-banner">
  <div class="container">
    <h1>Catálogo de Jogos</h1>
    <p><?= count($jogos) ?> jogos encontrados</p>
  </div>
</div>

<section class="section">
  <div class="container">
    <?php require __DIR__.'/../partials/flash.php'; ?>

    <!-- Filtros -->
    <form method="GET" action="" class="filter-bar">
      <input type="text" name="q" value="<?= htmlspecialchars($busca) ?>" placeholder="🔍 Buscar jogos..." class="filter-search">
      <div class="filter-cats">
        <a href="<?= BASE_URL ?>catalogo" class="filter-cat <?= !$catAtiva?'active':'' ?>">Todos</a>
        <?php foreach($categorias as $c): ?>
        <a href="<?= BASE_URL ?>catalogo?cat=<?= $c['id'] ?><?= $busca?'&q='.urlencode($busca):'' ?>"
           class="filter-cat <?= $catAtiva==$c['id']?'active':'' ?>">
          <?= $c['icone'] ?> <?= htmlspecialchars($c['nome']) ?>
        </a>
        <?php endforeach; ?>
      </div>
      <button type="submit" class="btn-neon sm">Buscar</button>
    </form>

    <!-- Grid -->
    <?php if(empty($jogos)): ?>
    <div class="empty-state">
      <span>🎮</span>
      <p>Nenhum jogo encontrado.</p>
      <a href="<?= BASE_URL ?>catalogo" class="btn-ghost">Limpar filtros</a>
    </div>
    <?php else: ?>
    <div class="games-grid catalog">
      <?php foreach($jogos as $j): ?>
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
    <?php endif; ?>
  </div>
</section>

<?php require __DIR__.'/../partials/footer.php'; ?>
