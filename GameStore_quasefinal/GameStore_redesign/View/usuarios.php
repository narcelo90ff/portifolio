<?php require_once 'View/navbar.php'; ?>

<div class="gs-page-header">
    <h1>Usuários</h1>
</div>

<table class="gs-table">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Email</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($usuarios as $usuario): ?>
        <tr>
            <td><?= htmlspecialchars($usuario['nome']) ?></td>
            <td><?= htmlspecialchars($usuario['email']) ?></td>
            <td>
                <div class="gs-actions">
                    <a href="index.php?p=editar-usuario&id=<?= $usuario['id'] ?>" class="botao">Editar</a>
                    <a href="index.php?p=excluir-usuario&id=<?= $usuario['id'] ?>"
                       class="btn btn-danger">Excluir</a>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once 'View/layout-footer.php'; ?>
