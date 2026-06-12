<?php

class Auth
{
    public static function verificarLogin()
    {
        if (!isset($_SESSION['usuario']))
        {
            header('Location: index.php?p=login');
            exit;
        }
    }

    public static function logout()
    {
        $_SESSION = [];

        session_destroy();

        setcookie(
            'ultimo_login',
            '',
            time() - 3600
        );

        header('Location: index.php?p=home');

        exit;
    }

   
public static function admin()
{
    self::verificarLogin();

    if ($_SESSION['usuario']['tipo'] !== 'admin')
    {
        header('Location: index.php?p=home');
        exit;
    }
}
public static function isAdmin()
{
    return isset($_SESSION['usuario'])
        && $_SESSION['usuario']['tipo'] === 'admin';
}
}