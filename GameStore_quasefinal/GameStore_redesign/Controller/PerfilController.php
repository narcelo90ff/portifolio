<?php

require_once 'Config/Auth.php';

class PerfilController
{
    public static function index()
    {
        Auth::verificarLogin();

        $usuario = Usuario::buscar($_SESSION['usuario']['id']);
        //$usuario = Usuario::buscar($id); Conferir se é necessário buscar o usuário novamente ou usar os dados da sessão

        require 'View/perfil.php';
    }
}