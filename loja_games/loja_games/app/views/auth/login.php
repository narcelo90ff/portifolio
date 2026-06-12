<?php require __DIR__.'/../partials/header.php'; ?>

<div class="auth-page">
  <div class="auth-bg">
    <div class="hero-grid"></div>
    <div class="hero-orb orb1"></div>
    <div class="hero-orb orb2"></div>
  </div>
  <div class="auth-card">
    <div class="auth-logo">
      <span class="logo-icon big">◈</span>
      <h1><?= APP_NAME ?></h1>
      <p>Entre na sua conta</p>
    </div>
    <?php require __DIR__.'/../partials/flash.php'; ?>
    <form method="POST" action="<?= BASE_URL ?>login" class="auth-form">
      <input type="hidden" name="csrf" value="<?= $csrf ?>">
      <div class="field">
        <label>Email</label>
        <input type="email" name="email" placeholder="seu@email.com" required autocomplete="email">
      </div>
      <div class="field">
        <label>Senha</label>
        <div class="input-eye">
          <input type="password" id="senha" name="senha" placeholder="••••••••" required>
          <button type="button" onclick="toggleSenha('senha')">👁</button>
        </div>
      </div>
      <button type="submit" class="btn-neon full">Entrar</button>
    </form>
    <div class="auth-links">
      <a href="<?= BASE_URL ?>recuperar">Esqueci minha senha</a>
      <span>·</span>
      <a href="<?= BASE_URL ?>cadastro">Criar conta</a>
    </div>
    <p class="auth-hint">Admin: <b>admin@sistema.com</b> / <b>password</b></p>
  </div>
</div>

<script src="<?= BASE_URL ?>js/main.js"></script>
</body></html>
