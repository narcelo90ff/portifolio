<?php

$token = Csrf::gerarToken();

require_once 'View/navbar.php';

?>

<div class="gs-page-header">
    <h1>Editar Usuário</h1>
</div>

<form method="post" class="gs-form">

    <input type="hidden" name="csrf" value="<?= $token ?>">

    <div class="form-group">
        <label>Nome</label>
        <input type="text" name="nome" value="<?= htmlspecialchars($usuario['nome']) ?>" required>
    </div>

    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required>
    </div>

    <div class="form-group">
        <label>CPF</label>
        <input type="text" name="cpf" value="<?= htmlspecialchars($usuario['cpf']) ?>" required>
    </div>

    <div class="form-group">
        <label>Data de Nascimento</label>
        <input type="date" name="data_nascimento" value="<?= htmlspecialchars($usuario['data_nascimento']) ?>" required>
    </div>

    <button type="submit">Atualizar</button>

</form>
