<?php

class Csrf
{
    public static function gerarToken()
    {
        if (!isset($_SESSION['csrf']))
        {
            $_SESSION['csrf'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['csrf'];
    }

    public static function validarToken($token)
    {
        return isset($_SESSION['csrf'])
            && hash_equals($_SESSION['csrf'], $token);
    }
}