<?php require __DIR__.'/../partials/header.php'; ?>
<?php require __DIR__.'/../partials/navbar.php'; ?>

<div class="page-banner admin-banner">
  <div class="container"><h1><?= $jogo?'Editar Jogo':'Novo Jogo' ?></h1></div>
</div>

<section class="section">
  <div class="container">
    <?php require __DIR__.'/../partials/flash.php'; ?>
    <div class="admin-form-card">
      <form method="POST" action="<?= BASE_URL ?>admin/jogo/salvar">
        <input type="hidden" name="csrf" value="<?= $csrf ?>">
        <input type="hidden" name="id" value="<?= $jogo['id']??'' ?>">

        <div class="form-row">
          <div class="field"><label>Nome *</label><input type="text" name="nome" value="<?= htmlspecialchars($jogo['nome']??'') ?>" required></div>
          <div class="field"><label>Plataforma</label><input type="text" name="plataforma" value="<?= htmlspecialchars($jogo['plataforma']??'PC') ?>"></div>
        </div>
        <div class="field"><label>Descrição Curta</label><input type="text" name="descricao_curta" value="<?= htmlspecialchars($jogo['descricao_curta']??'') ?>" placeholder="Uma linha resumindo o jogo"></div>
        <div class="field"><label>Descrição Completa</label><textarea name="descricao" rows="4"><?= htmlspecialchars($jogo['descricao']??'') ?></textarea></div>
        <div class="form-row">
          <div class="field"><label>Preço (R$) *</label><input type="number" step="0.01" name="preco" value="<?= $jogo['preco']??'' ?>" required></div>
          <div class="field"><label>Preço Promocional (R$)</label><input type="number" step="0.01" name="preco_promocional" value="<?= $jogo['preco_promocional']??'' ?>" placeholder="Vazio = sem promoção"></div>
        </div>
        <div class="form-row">
          <div class="field"><label>Categoria</label>
            <select name="categoria_id">
              <option value="">— Sem categoria —</option>
              <?php foreach($categorias as $c): ?>
              <option value="<?= $c['id'] ?>" <?= ($jogo['categoria_id']??'')==$c['id']?'selected':'' ?>><?= htmlspecialchars($c['nome']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="field"><label>Estoque</label><input type="number" name="estoque" value="<?= $jogo['estoque']??999 ?>"></div>
        </div>
        <div class="field"><label>URL da Imagem (capa)</label><input type="text" name="imagem_url" value="<?= htmlspecialchars($jogo['imagem_url']??'') ?>" placeholder="https://..."></div>
        <div class="field-check">
          <label><input type="checkbox" name="destaque" value="1" <?= ($jogo['destaque']??0)?'checked':'' ?>> Exibir como destaque na Home</label>
        </div>
        <div class="form-actions">
          <a href="<?= BASE_URL ?>admin/jogos" class="btn-ghost">Cancelar</a>
          <button type="submit" class="btn-neon"><?= $jogo?'💾 Salvar':'➕ Cadastrar' ?></button>
        </div>
      </form>
    </div>
  </div>
</section>

<?php require __DIR__.'/../partials/footer.php'; ?>
