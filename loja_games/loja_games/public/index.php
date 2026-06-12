<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../core/Model.php';
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Router.php';

require_once __DIR__ . '/../app/models/UsuarioModel.php';
require_once __DIR__ . '/../app/models/JogoModel.php';
require_once __DIR__ . '/../app/models/CarrinhoModel.php';
require_once __DIR__ . '/../app/models/GameCategoriaModel.php';

session_start();

$router = new Router();

// ─── Auth ───────────────────────────────────────────────────
$router->get ('/login',    'AuthController', 'login');
$router->post('/login',    'AuthController', 'doLogin');
$router->get ('/cadastro', 'AuthController', 'cadastro');
$router->post('/cadastro', 'AuthController', 'doCadastro');
$router->get ('/recuperar','AuthController', 'recuperar');
$router->post('/recuperar','AuthController', 'doRecuperar');
$router->get ('/logout',   'AuthController', 'logout');

// ─── Loja ────────────────────────────────────────────────────
$router->get('/',         'LojaController', 'index');
$router->get('/catalogo', 'LojaController', 'catalogo');
$router->get('/jogo',     'LojaController', 'jogo');

// ─── Carrinho ────────────────────────────────────────────────
$router->get ('/carrinho',           'CarrinhoController', 'index');
$router->post('/carrinho/adicionar', 'CarrinhoController', 'adicionar');
$router->post('/carrinho/remover',   'CarrinhoController', 'remover');
$router->post('/carrinho/finalizar', 'CarrinhoController', 'finalizar');

// ─── Admin ───────────────────────────────────────────────────
$router->get ('/admin',                   'AdminController', 'dashboard');
$router->get ('/admin/jogos',             'AdminController', 'jogos');
$router->get ('/admin/jogo',              'AdminController', 'jogoForm');
$router->post('/admin/jogo/salvar',       'AdminController', 'jogoSalvar');
$router->post('/admin/jogo/deletar',      'AdminController', 'jogoDeletar');
$router->get ('/admin/categorias',        'AdminController', 'categorias');
$router->get ('/admin/categoria',         'AdminController', 'catForm');
$router->post('/admin/categoria/salvar',  'AdminController', 'catSalvar');
$router->post('/admin/categoria/deletar', 'AdminController', 'catDeletar');
$router->get ('/admin/pedidos',           'AdminController', 'pedidos');
$router->post('/admin/pedido/status',     'AdminController', 'pedidoStatus');

$router->dispatch();
