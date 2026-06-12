<?php require __DIR__.'/../partials/header.php'; ?>
<?php require __DIR__.'/../partials/navbar.php'; ?>

<div class="page-banner admin-banner">
  <div class="container">
    <div style="display:flex;justify-content:space-between;align-items:center">
      <h1>🎮 Jogos</h1>
      <a href="<?= BASE_URL ?>admin/jogo" class="btn-neon">+ Novo Jogo</a>
    </div>
  </div>
</div>

<section class="section">
  <div class="container">
    <?php require __DIR__.'/../partials/flash.php'; ?>
    <div class="admin-table-wrap">
      <table class="admin-table">
        <thead><tr><th>#</th><th>Nome</th><th>Preço</th><th>Promo</th><th>Plataforma</th><th>Destaque</th><th>Ações</th></tr></thead>
        <tbody>
          <?php if(empty($jogos)): ?>
          <tr><td colspan="7" style="text-align:center;padding:2rem;color:#777">Nenhum jogo cadastrado.</td></tr>
          <?php else: foreach($jogos as $j): ?>
          <tr>
            <td><?= $j['id'] ?></td>
            <td><?= htmlspecialchars($j['nome']) ?></td>
            <td>R$ <?= number_format($j['preco'],2,',','.') ?></td>
            <td><?= $j['preco_promocional']?'R$ '.number_format($j['preco_promocional'],2,',','.'):'—' ?></td>
            <td><?= htmlspecialchars($j['plataforma']) ?></td>
            <td><?= $j['destaque']?'⭐':'—' ?></td>
            <td class="tbl-actions">
              <a href="<?= BASE_URL ?>admin/jogo?id=<?= $j['id'] ?>" class="tbl-btn edit">Editar</a>
              <form method="POST" action="<?= BASE_URL ?>admin/jogo/deletar" class="inline-f" onsubmit="return confirm('Excluir?')">
                <input type="hidden" name="csrf" value="<?= $csrf ?>">
                <input type="hidden" name="id" value="<?= $j['id'] ?>">
                <button class="tbl-btn del">Excluir</button>
              </form>
            </td>
          </tr>
          <?php endforeach; endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<?php require __DIR__.'/../partials/footer.php'; ?>
