<?php require __DIR__.'/../partials/header.php'; ?>

<div class="auth-page">
  <div class="auth-bg"><div class="hero-grid"></div><div class="hero-orb orb1"></div></div>
  <div class="auth-card wide">
    <div class="auth-logo">
      <span class="logo-icon big">◈</span>
      <h1>Recuperar Senha</h1>
      <p>Valide seu email, CPF e data de nascimento</p>
    </div>
    <?php require __DIR__.'/../partials/flash.php'; ?>
    <form method="POST" action="<?= BASE_URL ?>recuperar" class="auth-form">
      <input type="hidden" name="csrf" value="<?= $csrf ?>">
      <div class="form-row">
        <div class="field"><label>Email</label><input type="email" name="email" placeholder="seu@email.com" required></div>
        <div class="field"><label>CPF</label><input type="text" name="cpf" id="cpf" placeholder="000.000.000-00" maxlength="14" required></div>
      </div>
      <div class="field"><label>Data de Nascimento</label><input type="date" name="data_nascimento" required></div>
      <div class="form-row">
        <div class="field"><label>Nova Senha</label>
          <div class="input-eye"><input type="password" id="s1" name="nova_senha" placeholder="Mín. 6 caracteres" required><button type="button" onclick="toggleSenha('s1')">👁</button></div>
        </div>
        <div class="field"><label>Confirmar</label>
          <div class="input-eye"><input type="password" id="s2" name="confirmar" placeholder="Repita" required><button type="button" onclick="toggleSenha('s2')">👁</button></div>
        </div>
      </div>
      <button type="submit" class="btn-neon full">Redefinir Senha</button>
    </form>
    <div class="auth-links"><a href="<?= BASE_URL ?>login">Voltar ao login</a></div>
  </div>
</div>

<script src="<?= BASE_URL ?>js/main.js"></script>
</body></html>
