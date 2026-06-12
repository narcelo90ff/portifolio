<?php

require_once __DIR__ . '/../Model/Carrinho.php';
require_once __DIR__ . '/../Config/Auth.php';

class CarrinhoController
{
    public static function adicionar()
    {
        Auth::verificarLogin();

        Carrinho::adicionar(
            $_SESSION['usuario']['id'],
            $_GET['id']
        );

        header('Location: index.php?p=catalogo');
    }

    public static function listar()
    {
        Auth::verificarLogin();

        $carrinho = Carrinho::listar(
            $_SESSION['usuario']['id']
        );

        require 'View/carrinho.php';
    }

    public static function remover()
    {
        Auth::verificarLogin();

        Carrinho::remover(
            $_SESSION['usuario']['id'],
            $_GET['id']
        );

        header('Location: index.php?p=carrinho');
    }
}