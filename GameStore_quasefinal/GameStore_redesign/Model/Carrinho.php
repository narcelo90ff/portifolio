<?php

require_once 'Config/Banco.php';

class Carrinho
{
    public static function adicionar($usuario_id, $jogo_id)
    {
        $pdo = Banco::conectar();

        $sql = $pdo->prepare("
            INSERT INTO carrinho (usuario_id, jogo_id)
            VALUES (?, ?)
        ");

        return $sql->execute([$usuario_id, $jogo_id]);
    }

    public static function listar($usuario_id)
    {
        $pdo = Banco::conectar();

        $sql = $pdo->prepare("
            SELECT jogos.*
            FROM carrinho
            JOIN jogos ON jogos.id = carrinho.jogo_id
            WHERE carrinho.usuario_id = ?
        ");

        $sql->execute([$usuario_id]);

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function remover($usuario_id, $jogo_id)
    {
        $pdo = Banco::conectar();

        $sql = $pdo->prepare("
            DELETE FROM carrinho
            WHERE usuario_id = ? AND jogo_id = ?
        ");

        return $sql->execute([$usuario_id, $jogo_id]);
    }
}