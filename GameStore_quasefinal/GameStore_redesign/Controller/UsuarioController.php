<?php

require_once 'Model/Usuario.php';
require_once 'Config/Auth.php';
require_once 'Config/Csrf.php';

class UsuarioController
{
    public static function listar()
    {
        Auth::admin();

        $usuarios = Usuario::listar();

        require 'View/usuarios.php';
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

            Usuario::atualizar(
                $id,
                $_POST['nome'],
                $_POST['email'],
                $_POST['cpf'],
                $_POST['data_nascimento']
            );

            header(
                'Location: index.php?p=usuarios'
            );

            exit;
        }

        $usuario = Usuario::buscar($id);

        require 'View/usuario-editar.php';
    }

    public static function excluir()
    {
        Auth::admin();

        Usuario::excluir(
            $_GET['id']
        );

        header(
            'Location: index.php?p=usuarios'
        );

        exit;
    }
}