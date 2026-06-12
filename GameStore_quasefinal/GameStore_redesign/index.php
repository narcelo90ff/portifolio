<?php

session_start();

require_once 'Config/Auth.php';
require_once 'Config/Csrf.php';

require_once 'Controller/AuthController.php';
require_once 'Controller/CategoriaController.php';
require_once 'Controller/JogoController.php';
require_once 'Controller/UsuarioController.php';
require_once 'Controller/CarrinhoController.php';
require_once 'Controller/PerfilController.php';



$pagina = $_GET['p'] ?? 'home';

switch ($pagina)
{
    case 'home':
        require_once 'View/home.php';
        break;

    case 'catalogo':
    JogoController::catalogoPublico();
    break;

    case 'categorias-publico':
    CategoriaController::publico();
    break;

    case 'sobre':
        require_once 'View/sobre.php';
        break;

    case 'login':
    AuthController::login();
    break;

    case 'cadastro':
    AuthController::cadastrar();
    break;

    case 'dashboard':
    Auth::admin();
    require_once 'View/dashboard.php';
    break;
    
    case 'categorias':
    CategoriaController::listar();
    break;

    case 'nova-categoria':
    CategoriaController::novo();
    break;

    case 'editar-categoria':
    CategoriaController::editar();
    break;

    case 'excluir-categoria':
    CategoriaController::excluir();
    break;

    case 'jogos':
    JogoController::listar();
    break;

    case 'novo-jogo':
    JogoController::novo();
    break;

    case 'editar-jogo':
    JogoController::editar();
    break;

    case 'excluir-jogo':
    JogoController::excluir();
    break;

    case 'usuarios':
    UsuarioController::listar();
    break;

    case 'editar-usuario':
    UsuarioController::editar();
    break;

    case 'excluir-usuario':
    UsuarioController::excluir();
    break;

    case 'logout':
    Auth::logout();
    break;

    case 'recuperar-senha':
    AuthController::recuperarSenha();
    break;

case 'carrinho':
    CarrinhoController::listar();
    break;

case 'adicionar-carrinho':
    CarrinhoController::adicionar();
    break;

case 'remover-carrinho':
    CarrinhoController::remover();
    break;

case 'perfil':
    PerfilController::index();
    break;
    
    case 'destaques':
    require_once 'View/destaques.php';
    break;

    default:
        require_once 'View/home.php';
        break;
}