<?php

$token = Csrf::gerarToken();

require_once 'View/navbar.php';

?>

<div class="gs-page-header">
    <h1>Editar Jogo</h1>
</div>

<form method="post" class="gs-form">

    <input type="hidden" name="csrf" value="<?= $token ?>">

    <div class="form-group">
        <label>Título</label>
        <input type="text" name="titulo" value="<?= htmlspecialchars($jogo['titulo']) ?>" required>
    </div>

    <div class="form-group">
        <label>Descrição</label>
        <textarea name="descricao"><?= htmlspecialchars($jogo['descricao']) ?></textarea>
    </div>

    <div class="form-group">
        <label>Preço</label>
        <input type="number" step="0.01" name="preco" value="<?= htmlspecialchars($jogo['preco']) ?>" required>
    </div>

    <div class="form-group">
        <label>Categoria</label>
        <select name="categoria_id">
            <?php foreach($categorias as $categoria): ?>
            <option value="<?= $categoria['id'] ?>"
                <?= $categoria['id'] == $jogo['categoria_id'] ? 'selected' : '' ?>>
                <?= $categoria['nome'] ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>

    <button type="submit">Atualizar</button>

</form>
