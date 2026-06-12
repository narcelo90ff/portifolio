<?php

require_once 'Config/Banco.php';

class Jogo
{
    public static function listar()
    {
        $pdo = Banco::conectar();

        $sql = $pdo->query("
            SELECT
                jogos.*,
                categorias.nome AS categoria_nome
            FROM jogos
            LEFT JOIN categorias
            ON categorias.id = jogos.categoria_id
            ORDER BY jogos.titulo
        ");

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function cadastrar(
        $titulo,
        $descricao,
        $preco,
        $categoria
    )
    {
        $pdo = Banco::conectar();

        $sql = $pdo->prepare("
            INSERT INTO jogos
            (
                titulo,
                descricao,
                preco,
                categoria_id
            )
            VALUES
            (
                ?,
                ?,
                ?,
                ?
            )
        ");

        return $sql->execute([
            $titulo,
            $descricao,
            $preco,
            $categoria
        ]);
    }

    public static function buscar($id)
{
    $pdo = Banco::conectar();

    $sql = $pdo->prepare("
        SELECT *
        FROM jogos
        WHERE id = ?
    ");

    $sql->execute([$id]);

    return $sql->fetch(PDO::FETCH_ASSOC);
}

public static function atualizar(
    $id,
    $titulo,
    $descricao,
    $preco,
    $categoria
)
{
    $pdo = Banco::conectar();

    $sql = $pdo->prepare("
        UPDATE jogos
        SET
            titulo = ?,
            descricao = ?,
            preco = ?,
            categoria_id = ?
        WHERE id = ?
    ");

    return $sql->execute([
        $titulo,
        $descricao,
        $preco,
        $categoria,
        $id
    ]);
}

public static function excluir($id)
{
    $pdo = Banco::conectar();

    $sql = $pdo->prepare("
        DELETE FROM jogos
        WHERE id = ?
    ");

    return $sql->execute([$id]);
}
public static function total()
{
    $pdo = Banco::conectar();

    return $pdo
        ->query("SELECT COUNT(*) FROM jogos")
        ->fetchColumn();
}
}