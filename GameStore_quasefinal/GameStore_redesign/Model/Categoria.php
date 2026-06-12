<?php

require_once 'Config/Banco.php';

class Categoria
{
    public static function listar()
    {
        $pdo = Banco::conectar();

        $sql = $pdo->query("
            SELECT *
            FROM categorias
            ORDER BY nome
        ");

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function buscar($id)
    {
        $pdo = Banco::conectar();

        $sql = $pdo->prepare("
            SELECT *
            FROM categorias
            WHERE id = ?
        ");

        $sql->execute([$id]);

        return $sql->fetch(PDO::FETCH_ASSOC);
    }

    public static function cadastrar($nome)
    {
        $pdo = Banco::conectar();

        $sql = $pdo->prepare("
            INSERT INTO categorias(nome)
            VALUES(?)
        ");

        return $sql->execute([$nome]);
    }

    public static function atualizar($id, $nome)
    {
        $pdo = Banco::conectar();

        $sql = $pdo->prepare("
            UPDATE categorias
            SET nome = ?
            WHERE id = ?
        ");

        return $sql->execute([
            $nome,
            $id
        ]);
    }

    public static function excluir($id)
    {
        $pdo = Banco::conectar();

        $sql = $pdo->prepare("
            DELETE FROM categorias
            WHERE id = ?
        ");

        return $sql->execute([$id]);
    }

    public static function total()
{
    $pdo = Banco::conectar();

    return $pdo
        ->query("SELECT COUNT(*) FROM categorias")
        ->fetchColumn();
}
}