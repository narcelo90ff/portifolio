<?php

require_once 'Config/Banco.php';

class Usuario
{
    public static function cadastrar(
    $nome,
    $email,
    $cpf,
    $dataNascimento,
    $senha
)
{
    $pdo = Banco::conectar();

    // 🔥 VERIFICAR DUPLICIDADE (EMAIL OU CPF)
    $verifica = $pdo->prepare("
        SELECT id
        FROM usuarios
        WHERE email = ? OR cpf = ?
    ");

    $verifica->execute([
        $email,
        $cpf
    ]);

    if ($verifica->fetch())
    {
        // já existe usuário
        return false;
    }

    // criptografar senha
    $senhaHash = password_hash(
        $senha,
        PASSWORD_DEFAULT
    );

    // inserir usuário
    $sql = $pdo->prepare("
        INSERT INTO usuarios
        (
            nome,
            email,
            cpf,
            data_nascimento,
            senha
        )
        VALUES
        (
            ?,
            ?,
            ?,
            ?,
            ?
        )
    ");

    return $sql->execute([
        $nome,
        $email,
        $cpf,
        $dataNascimento,
        $senhaHash
    ]);
}

    public static function buscarPorEmail($email)
    {
        $pdo = Banco::conectar();

        $sql = $pdo->prepare("
            SELECT *
            FROM usuarios
            WHERE email = ?
        ");

        $sql->execute([$email]);

        return $sql->fetch(PDO::FETCH_ASSOC);
    }

    public static function listar()
{
    $pdo = Banco::conectar();

    $sql = $pdo->query("
        SELECT *
        FROM usuarios
        ORDER BY nome
    ");

    return $sql->fetchAll(PDO::FETCH_ASSOC);
}

public static function buscar($id)
{
    $pdo = Banco::conectar();

    $sql = $pdo->prepare("
        SELECT *
        FROM usuarios
        WHERE id = ?
    ");

    $sql->execute([$id]);

    return $sql->fetch(PDO::FETCH_ASSOC);
}

public static function atualizar(
    $id,
    $nome,
    $email,
    $cpf,
    $dataNascimento
)
{
    $pdo = Banco::conectar();

    $sql = $pdo->prepare("
        UPDATE usuarios
        SET
            nome = ?,
            email = ?,
            cpf = ?,
            data_nascimento = ?
        WHERE id = ?
    ");

    return $sql->execute([
        $nome,
        $email,
        $cpf,
        $dataNascimento,
        $id
    ]);
}

public static function excluir($id)
{
    $pdo = Banco::conectar();

    $sql = $pdo->prepare("
        DELETE FROM usuarios
        WHERE id = ?
    ");

    return $sql->execute([$id]);
}

public static function buscarPorCpfDataNascimento(
    $cpf,
    $dataNascimento
)
{
    $pdo = Banco::conectar();

    $sql = $pdo->prepare("
        SELECT *
        FROM usuarios
        WHERE cpf = ?
        AND data_nascimento = ?
    ");

    $sql->execute([
        $cpf,
        $dataNascimento
    ]);

    return $sql->fetch(PDO::FETCH_ASSOC);
}

public static function atualizarSenha(
    $id,
    $senha
)
{
    $pdo = Banco::conectar();

    $senhaHash = password_hash(
        $senha,
        PASSWORD_DEFAULT
    );

    $sql = $pdo->prepare("
        UPDATE usuarios
        SET senha = ?
        WHERE id = ?
    ");

    return $sql->execute([
        $senhaHash,
        $id
    ]);
}

public static function total()
{
    $pdo = Banco::conectar();

    return $pdo
        ->query("SELECT COUNT(*) FROM usuarios")
        ->fetchColumn();
}
}