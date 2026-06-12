<?php

require_once 'Model/Categoria.php';
require_once 'Config/Auth.php';
require_once 'Config/Csrf.php';

class CategoriaController
{
    public static function listar()
    {
        Auth::admin();

        $categorias = Categoria::listar();

        require 'View/categorias.php';
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

            Categoria::cadastrar(
                $_POST['nome']
            );

            header(
                'Location: index.php?p=categorias'
            );

            exit;
        }

        require 'View/categoria-form.php';
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

        Categoria::atualizar(
            $id,
            $_POST['nome']
        );

        header('Location: index.php?p=categorias');
        exit;
    }

    $categoria = Categoria::buscar($id);

    require 'View/categoria-editar.php';
}

public static function excluir()
{
    Auth::admin();

    $id = $_GET['id'];

    Categoria::excluir($id);

    header('Location: index.php?p=categorias');
    exit;
}
public static function listarTodas()
{
    return self::listar();
}

public static function publico()
{
    $categorias = Categoria::listar();

    require 'View/categorias-publico.php';
}
}