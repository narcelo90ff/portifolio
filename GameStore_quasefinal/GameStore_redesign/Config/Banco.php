<?php

class Banco
{
    private static $conexao = null;

    public static function conectar()
    {
        if (self::$conexao === null)
        {
            self::$conexao = new PDO(
                "mysql:host=localhost;dbname=gamestore;charset=utf8",
                "root",
                ""
            );

            self::$conexao->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );
        }

        return self::$conexao;
    }
}