<?php require_once 'View/navbar.php'; ?>

<div class="gs-page-header">
    <h1>Jogos</h1>
    <a href="index.php?p=novo-jogo" class="botao">+ Novo Jogo</a>
</div>

<table class="gs-table">
    <thead>
        <tr>
            <th>Título</th>
            <th>Categoria</th>
            <th>Preço</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($jogos as $jogo): ?>
        <tr>
            <td><strong><?= htmlspecialchars($jogo['titulo']) ?></strong></td>
            <td><?= htmlspecialchars($jogo['categoria_nome']) ?></td>
            <td class="gs-price">R$ <?= number_format(htmlspecialchars($jogo['preco']), 2, ',', '.') ?></td>
            <td>
                <div class="gs-actions">
                    <a href="index.php?p=editar-jogo&id=<?= $jogo['id'] ?>" class="botao">Editar</a>
                    <a href="index.php?p=excluir-jogo&id=<?= $jogo['id'] ?>"
                       class="btn btn-danger">Excluir</a>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
