<?php require_once 'View/navbar.php'; ?>

<div class="gs-page-header">
    <h1>Categorias</h1>
    <a href="index.php?p=nova-categoria" class="botao">+ Nova Categoria</a>
</div>

<?php if (!empty($categorias)): ?>

    <table class="gs-table">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($categorias as $categoria): ?>
            <tr>
                <td><?= htmlspecialchars($categoria['nome']) ?></td>
                <td>
                    <div class="gs-actions">
                        <a href="index.php?p=editar-categoria&id=<?= $categoria['id'] ?>" class="botao">Editar</a>
                        <a href="index.php?p=excluir-categoria&id=<?= $categoria['id'] ?>"
                           class="btn btn-danger">Excluir</a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<?php else: ?>

    <div class="card">
        <p>Nenhuma categoria cadastrada.</p>
    </div>

<?php endif; ?>

<?php require_once 'View/layout-footer.php'; ?>
