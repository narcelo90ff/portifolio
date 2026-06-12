<?php require_once 'View/navbar.php';

$token = Csrf::gerarToken();

?>



<div class="login-wrapper">

    <div class="login-card">

        <h1>🎮 Acesse sua conta</h1>

        <p>Entre para explorar a GameStore</p>

        <?php if (!empty($erro)): ?>
            <div class="msg-erro"><?= $erro ?></div>
        <?php endif; ?>

        
        <form method="post" class="gs-form">

            <input type="hidden" name="csrf" value="<?= $token ?>">

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="Digite seu email" required>
            </div>

            <div class="form-group">
                <label>Senha</label>
                <input type="password" name="senha" placeholder="Digite sua senha" required>
            </div>

            <button type="submit" style="width:100%;">
                Entrar
            </button>

            <p style="margin-top:1rem; text-align:center;">
                <a href="index.php?p=recuperar-senha">Esqueci minha senha</a>
            </p>

        </form>

    </div>

</div>

<?php require_once 'View/layout-footer.php'; ?>