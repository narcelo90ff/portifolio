<?php require_once 'View/navbar.php';

$token = Csrf::gerarToken();

?>

<div class="login-wrapper">

    <div class="login-card">

        <h1>🎮 Criar conta</h1>

        <p>Cadastre-se para acessar a GameStore</p>

        <?php if (!empty($erro)): ?>
            <div class="msg-erro"><?= $erro ?></div>
        <?php endif; ?>

        <form method="post" class="gs-form">

            <input type="hidden" name="csrf" value="<?= $token ?>">

            <div class="form-group">
                <label>Nome</label>
                <input type="text" name="nome" placeholder="Seu nome" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="Seu email" required>
            </div>

            <div class="form-group">
                <label>CPF</label>
                <input type="text" name="cpf" placeholder="000.000.000-00" required>
            </div>

            <div class="form-group">
                <label>Data de Nascimento</label>
                <input type="date" name="data_nascimento" required>
            </div>

            <div class="form-group">
                <label>Senha</label>
                <input type="password" name="senha" placeholder="Crie uma senha" required>
            </div>

            <button type="submit" style="width:100%;">
                Criar conta
            </button>

            <p style="margin-top:1rem; text-align:center;">
                <a href="index.php?p=login">Já tenho conta</a>
            </p>

        </form>

    </div>

</div>

<?php require_once 'View/layout-footer.php'; ?>