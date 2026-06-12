<?php

$token = Csrf::gerarToken();

require_once 'View/navbar.php';

?>

<div class="gs-page-header">
    <h1>Editar Categoria</h1>
</div>

<form method="post" class="gs-form">

    <input type="hidden" name="csrf" value="<?= $token ?>">

    <div class="form-group">
        <label>Nome</label>
        <input type="text" name="nome" value="<?= htmlspecialchars($categoria['nome']) ?>" required>
    </div>

    <button type="submit">Atualizar</button>

</form>
