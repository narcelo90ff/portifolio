<?php require __DIR__.'/../partials/header.php'; ?>
<?php require __DIR__.'/../partials/navbar.php'; ?>

<div class="page-banner admin-banner">
  <div class="container"><h1>⚙ Painel Admin</h1></div>
</div>

<section class="section">
  <div class="container">
    <?php require __DIR__.'/../partials/flash.php'; ?>

    <div class="admin-stats">
      <div class="astat"><span class="astat-num"><?= $stats['jogos'] ?></span><span>Jogos</span></div>
      <div class="astat"><span class="astat-num"><?= $stats['usuarios'] ?></span><span>Usuários</span></div>
      <div class="astat"><span class="astat-num"><?= $stats['pedidos'] ?></span><span>Pedidos</span></div>
      <div class="astat"><span class="astat-num neon-text">R$ <?= number_format($stats['receita'],2,',','.') ?></span><span>Receita (pagos)</span></div>
    </div>

    <div class="admin-shortcuts">
      <a href="<?= BASE_URL ?>admin/jogos" class="shortcut-card">🎮 Gerenciar Jogos</a>
      <a href="<?= BASE_URL ?>admin/jogo" class="shortcut-card accent">➕ Novo Jogo</a>
      <a href="<?= BASE_URL ?>admin/categorias" class="shortcut-card">🏷 Categorias</a>
      <a href="<?= BASE_URL ?>admin/pedidos" class="shortcut-card">📦 Pedidos</a>
    </div>

    <h2 class="section-title mt"><span class="neon-text">◈</span> Últimos Pedidos</h2>
    <div class="admin-table-wrap">
      <table class="admin-table">
        <thead><tr><th>#</th><th>Cliente</th><th>Total</th><th>Status</th><th>Data</th></tr></thead>
        <tbody>
          <?php foreach($pedidos as $p): ?>
          <tr>
            <td>#<?= $p['id'] ?></td>
            <td><?= htmlspecialchars($p['nome']) ?></td>
            <td>R$ <?= number_format($p['total'],2,',','.') ?></td>
            <td><span class="status-badge <?= $p['status'] ?>"><?= $p['status'] ?></span></td>
            <td><?= date('d/m/Y H:i',strtotime($p['criado_em'])) ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<?php require __DIR__.'/../partials/footer.php'; ?>
