<?php

require_once 'Model/Usuario.php';
require_once 'Config/Auth.php';
require_once 'Config/Csrf.php';

class AuthController
{
public static function cadastrar()
{
    $erro = null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        if (!Csrf::validarToken($_POST['csrf']))
        {
            die('Token CSRF inválido');
        }

        $resultado = Usuario::cadastrar(
            $_POST['nome'],
            $_POST['email'],
            $_POST['cpf'],
            $_POST['data_nascimento'],
            $_POST['senha']
        );

        if (!$resultado)
        {
            $erro = "Email ou CPF já cadastrado!";
        }
        else
        {
            header('Location: index.php?p=login');
            exit;
        }
    }

    require 'View/cadastro.php';
}

    public static function login()
{

    $erro = null;
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        if (!Csrf::validarToken($_POST['csrf']))
        {
            die('Token CSRF inválido');
        }

        $usuario = Usuario::buscarPorEmail($_POST['email']);


        if ($usuario && password_verify($_POST['senha'], $usuario['senha']))
        {

            if ($usuario['email'] === 'admin@gamestore.com')
            {
                $usuario['tipo'] = 'admin';
            }
            else
            {
                $usuario['tipo'] = 'usuario';
            }

            $_SESSION['usuario'] = $usuario;

            setcookie(
                'ultimo_login',
                date('d/m/Y H:i'),
                time() + 86400
            );

            header('Location: index.php?p=home');
            exit;
        }

        $erro = "Email ou senha inválidos";
    }

    require 'View/login.php';
}
 public static function recuperarSenha()
    {
        $erro = null;
        $sucesso = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            if (!Csrf::validarToken($_POST['csrf']))
            {
                die('CSRF inválido');
            }

            $usuario = Usuario::buscarPorCpfDataNascimento(
                $_POST['cpf'],
                $_POST['data_nascimento']
            );

            if ($usuario)
            {
                Usuario::atualizarSenha(
                    $usuario['id'],
                    $_POST['nova_senha']
                );

                $sucesso = "Senha atualizada com sucesso!";
            }
            else
            {
                $erro = "CPF ou data de nascimento inválidos.";
            }
        }

        require 'View/recuperarSenha.php';
    }
}