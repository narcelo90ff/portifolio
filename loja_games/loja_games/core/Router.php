<?php
class Router {
    private array $routes = [];
    public function get(string $p, string $c, string $m): void  { $this->routes['GET'][$p]  = [$c,$m]; }
    public function post(string $p, string $c, string $m): void { $this->routes['POST'][$p] = [$c,$m]; }
    public function dispatch(): void {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $base = '/loja_games/loja_games/public';
        if (str_starts_with($uri, $base)) $uri = substr($uri, strlen($base));
        $uri = '/' . trim($uri, '/');
        if ($uri === '/') $uri = '/';
        if (isset($this->routes[$method][$uri])) {
            [$ctrl, $action] = $this->routes[$method][$uri];
            require_once __DIR__ . "/../app/controllers/{$ctrl}.php";
            (new $ctrl())->$action();
        } else {
            http_response_code(404);
            require __DIR__ . '/../app/views/404.php';
        }
    }
}
