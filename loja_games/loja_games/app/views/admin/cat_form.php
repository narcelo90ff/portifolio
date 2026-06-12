<?php require __DIR__.'/../partials/header.php'; ?>
<?php require __DIR__.'/../partials/navbar.php'; ?>

<div class="page-banner admin-banner">
  <div class="container"><h1><?= $cat?'Editar Categoria':'Nova Categoria' ?></h1></div>
</div>

<section class="section">
  <div class="container">
    <?php require __DIR__.'/../partials/flash.php'; ?>
    <div class="admin-form-card narrow">
      <form method="POST" action="<?= BASE_URL ?>admin/categoria/salvar">
        <input type="hidden" name="csrf" value="<?= $csrf ?>">
        <input type="hidden" name="id" value="<?= $cat['id']??'' ?>">
        <div class="field"><label>Nome *</label><input type="text" name="nome" value="<?= htmlspecialchars($cat['nome']??'') ?>" required></div>
        <div class="field"><label>Slug *</label><input type="text" name="slug" value="<?= htmlspecialchars($cat['slug']??'') ?>" placeholder="ex: acao" required></div>
        <div class="field"><label>Ícone (emoji)</label><input type="text" name="icone" value="<?= $cat['icone']??'🎮' ?>" maxlength="5"></div>
        <div class="form-actions">
          <a href="<?= BASE_URL ?>admin/categorias" class="btn-ghost">Cancelar</a>
          <button type="submit" class="btn-neon">Salvar</button>
        </div>
      </form>
    </div>
  </div>
</section>

<?php require __DIR__.'/../partials/footer.php'; ?>
