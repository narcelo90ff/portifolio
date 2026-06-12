<?php

$token = Csrf::gerarToken();

require_once 'View/navbar.php';

?>

<div class="login-wrapper">

    <div class="login-card">

        <h1>🔐 Recuperar Senha</h1>

        <p>Confirme seus dados para redefinir sua senha</p>

         <?php if (!empty($erro)): ?>
            <div class="msg-erro"><?= $erro ?></div>
        <?php endif; ?>

        <?php if (!empty($sucesso)): ?>
            <div class="msg-sucesso"><?= $sucesso ?></div>
        <?php endif; ?>

        <form method="post" class="gs-form">

            <input type="hidden" name="csrf" value="<?= $token ?>">

            <div class="form-group">
                <label>CPF</label>
                <input type="text" name="cpf" required>
            </div>

            <div class="form-group">
                <label>Data de Nascimento</label>
                <input type="date" name="data_nascimento" required>
            </div>

            <div class="form-group">
                <label>Nova Senha</label>
                <input type="password" name="nova_senha" required>
            </div>

            <button type="submit" style="width:100%;">
                Alterar Senha
            </button>

            <p style="margin-top:1rem; text-align:center;">
                <a href="index.php?p=login">Voltar para login</a>
            </p>

        </form>

    </div>

</div>

<?php require_once 'View/layout-footer.php'; ?>