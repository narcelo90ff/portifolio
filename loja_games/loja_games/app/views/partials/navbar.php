<nav class="navbar">
  <a href="<?= BASE_URL ?>" class="nav-logo">
    <span class="logo-icon">◈</span>
    <span><?= APP_NAME ?></span>
  </a>
  <div class="nav-center">
    <a href="<?= BASE_URL ?>" class="<?= (parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH)==='/projeto_mvc/loja_games/public/'||parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH)==='/projeto_mvc/loja_games/public') ? 'active':'' ?>">Home</a>
    <a href="<?= BASE_URL ?>catalogo" class="<?= str_contains($_SERVER['REQUEST_URI'],'catalogo')?'active':'' ?>">Catálogo</a>
    <?php if(isset($_SESSION['perfil'])&&$_SESSION['perfil']==='admin'): ?>
    <a href="<?= BASE_URL ?>admin" class="<?= str_contains($_SERVER['REQUEST_URI'],'admin')?'active':'' ?>">Admin</a>
    <?php endif; ?>
  </div>
  <div class="nav-right">
    <?php if(isset($_SESSION['uid'])): ?>
      <a href="<?= BASE_URL ?>carrinho" class="nav-cart">
        🛒 <span class="cart-count"><?= $cc ?? 0 ?></span>
      </a>
      <div class="nav-user-wrap">
        <span class="nav-user-name"><?= htmlspecialchars($_SESSION['nome']) ?></span>
        <a href="<?= BASE_URL ?>logout" class="btn-nav-out">Sair</a>
      </div>
    <?php else: ?>
      <a href="<?= BASE_URL ?>login"   class="btn-nav-ghost">Login</a>
      <a href="<?= BASE_URL ?>cadastro" class="btn-nav-neon">Cadastrar</a>
    <?php endif; ?>
  </div>
  <button class="nav-mobile-btn" onclick="toggleMobileNav()">☰</button>
</nav>
<div class="mobile-nav" id="mobileNav">
  <a href="<?= BASE_URL ?>">Home</a>
  <a href="<?= BASE_URL ?>catalogo">Catálogo</a>
  <?php if(isset($_SESSION['uid'])): ?>
    <a href="<?= BASE_URL ?>carrinho">Carrinho (<?= $cc??0 ?>)</a>
    <a href="<?= BASE_URL ?>logout">Sair</a>
  <?php else: ?>
    <a href="<?= BASE_URL ?>login">Login</a>
    <a href="<?= BASE_URL ?>cadastro">Cadastrar</a>
  <?php endif; ?>
</div>
