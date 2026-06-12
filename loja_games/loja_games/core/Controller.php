<?php
abstract class Controller {
    protected function view(string $view, array $data = []): void {
        extract($data);
        $path = __DIR__ . "/../app/views/{$view}.php";
        if (!file_exists($path)) die("View não encontrada: $view");
        require $path;
    }
    protected function redirect(string $url): void {
        header("Location: " . BASE_URL . ltrim($url, '/'));
        exit;
    }
    protected function isLoggedIn(): bool { return isset($_SESSION['uid']); }
    protected function isAdmin(): bool { return ($_SESSION['perfil'] ?? '') === 'admin'; }
    protected function requireLogin(): void {
        if (!$this->isLoggedIn()) {
            $this->setFlash('warning', 'Faça login para continuar.');
            $this->redirect('login');
        }
    }
    protected function requireAdmin(): void {
        $this->requireLogin();
        if (!$this->isAdmin()) { $this->setFlash('danger','Acesso negado.'); $this->redirect(''); }
    }
    protected function csrf(): string {
        if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
        return $_SESSION['csrf'];
    }
    protected function validateCsrf(): void {
        if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) {
            $this->setFlash('danger','Token inválido.'); header("Location: ".$_SERVER['HTTP_REFERER']); exit;
        }
        unset($_SESSION['csrf']);
    }
    protected function setFlash(string $t, string $m): void { $_SESSION['flash'] = ['t'=>$t,'m'=>$m]; }
    protected function getFlash(): ?array {
        if (isset($_SESSION['flash'])) { $f=$_SESSION['flash']; unset($_SESSION['flash']); return $f; }
        return null;
    }
    protected function cartCount(): int {
        if (!$this->isLoggedIn()) return 0;
        $s = Database::getInstance()->getConnection()->prepare("SELECT SUM(quantidade) FROM carrinho WHERE usuario_id=?");
        $s->execute([$_SESSION['uid']]);
        return (int)$s->fetchColumn();
    }
}
