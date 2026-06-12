<?php require __DIR__.'/../partials/header.php'; ?>
<?php require __DIR__.'/../partials/navbar.php'; ?>

<div class="page-banner admin-banner">
  <div class="container">
    <div style="display:flex;justify-content:space-between;align-items:center">
      <h1>🏷 Categorias</h1>
      <a href="<?= BASE_URL ?>admin/categoria" class="btn-neon">+ Nova Categoria</a>
    </div>
  </div>
</div>

<section class="section">
  <div class="container">
    <?php require __DIR__.'/../partials/flash.php'; ?>
    <div class="admin-table-wrap">
      <table class="admin-table">
        <thead><tr><th>#</th><th>Ícone</th><th>Nome</th><th>Slug</th><th>Ações</th></tr></thead>
        <tbody>
          <?php if(empty($categorias)): ?>
          <tr><td colspan="5" style="text-align:center;padding:2rem;color:#777">Nenhuma categoria.</td></tr>
          <?php else: foreach($categorias as $c): ?>
          <tr>
            <td><?= $c['id'] ?></td>
            <td style="font-size:1.5rem"><?= $c['icone'] ?></td>
            <td><?= htmlspecialchars($c['nome']) ?></td>
            <td><code><?= htmlspecialchars($c['slug']) ?></code></td>
            <td class="tbl-actions">
              <a href="<?= BASE_URL ?>admin/categoria?id=<?= $c['id'] ?>" class="tbl-btn edit">Editar</a>
              <form method="POST" action="<?= BASE_URL ?>admin/categoria/deletar" class="inline-f" onsubmit="return confirm('Excluir?')">
                <input type="hidden" name="csrf" value="<?= $csrf ?>">
                <input type="hidden" name="id" value="<?= $c['id'] ?>">
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
