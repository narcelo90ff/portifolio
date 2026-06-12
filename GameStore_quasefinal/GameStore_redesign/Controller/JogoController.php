<?php

require_once 'Model/Jogo.php';
require_once 'Model/Categoria.php';
require_once 'Config/Auth.php';
require_once 'Config/Csrf.php';

class JogoController
{
    public static function listar()
    {
        Auth::admin();

        $jogos = Jogo::listar();

        require 'View/jogo.php';
    }

    public static function novo()
    {
        Auth::admin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            if (!Csrf::validarToken($_POST['csrf']))
            {
                die('CSRF inválido');
            }

            Jogo::cadastrar(
                $_POST['titulo'],
                $_POST['descricao'],
                $_POST['preco'],
                $_POST['categoria_id']
            );

            header(
                'Location: index.php?p=jogos'
            );

            exit;
        }

        $categorias = Categoria::listar();

        require 'View/jogo-form.php';
    }

    public static function editar()
{
    Auth::admin();

    $id = $_GET['id'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        if (!Csrf::validarToken($_POST['csrf']))
        {
            die('CSRF inválido');
        }

        Jogo::atualizar(
            $id,
            $_POST['titulo'],
            $_POST['descricao'],
            $_POST['preco'],
            $_POST['categoria_id']
        );

        header(
            'Location: index.php?p=jogos'
        );

        exit;
    }

    $jogo = Jogo::buscar($id);

    $categorias = Categoria::listar();

    require 'View/jogo-editar.php';
}

public static function excluir()
{
    Auth::admin();

    $id = $_GET['id'];

    Jogo::excluir($id);

    header(
        'Location: index.php?p=jogos'
    );

    exit;
}

public static function catalogoPublico()
{
    $jogos = Jogo::listar();

    require 'View/catalogo.php';
}
}