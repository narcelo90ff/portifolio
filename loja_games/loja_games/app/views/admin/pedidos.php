<?php require __DIR__.'/../partials/header.php'; ?>
<?php require __DIR__.'/../partials/navbar.php'; ?>

<div class="page-banner admin-banner">
  <div class="container"><h1>📦 Pedidos</h1></div>
</div>

<section class="section">
  <div class="container">
    <?php require __DIR__.'/../partials/flash.php'; ?>
    <div class="admin-table-wrap">
      <table class="admin-table">
        <thead><tr><th>#</th><th>Cliente</th><th>Total</th><th>Status</th><th>Data</th><th>Ação</th></tr></thead>
        <tbody>
          <?php if(empty($pedidos)): ?>
          <tr><td colspan="6" style="text-align:center;padding:2rem;color:#777">Nenhum pedido.</td></tr>
          <?php else: foreach($pedidos as $p): ?>
          <tr>
            <td>#<?= $p['id'] ?></td>
            <td><?= htmlspecialchars($p['nome']) ?></td>
            <td>R$ <?= number_format($p['total'],2,',','.') ?></td>
            <td><span class="status-badge <?= $p['status'] ?>"><?= $p['status'] ?></span></td>
            <td><?= date('d/m/Y H:i',strtotime($p['criado_em'])) ?></td>
            <td>
              <form method="POST" action="<?= BASE_URL ?>admin/pedido/status" class="inline-f status-form">
                <input type="hidden" name="csrf" value="<?= $csrf ?>">
                <input type="hidden" name="id" value="<?= $p['id'] ?>">
                <select name="status" onchange="this.form.submit()">
                  <?php foreach(['pendente','pago','cancelado'] as $st): ?>
                  <option value="<?= $st ?>" <?= $p['status']===$st?'selected':'' ?>><?= ucfirst($st) ?></option>
                  <?php endforeach; ?>
                </select>
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
