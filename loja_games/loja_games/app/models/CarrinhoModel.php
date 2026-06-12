<?php
class CarrinhoModel extends Model {
    protected string $table = 'carrinho';

    public function getItens(int $uid): array {
        $s = $this->db->prepare("
            SELECT c.*, j.nome, j.preco, j.preco_promocional, j.imagem_url, j.plataforma
            FROM carrinho c JOIN jogos j ON j.id=c.jogo_id
            WHERE c.usuario_id=? ORDER BY c.id DESC
        ");
        $s->execute([$uid]);
        return $s->fetchAll();
    }

    public function adicionar(int $uid, int $jid): void {
        $s = $this->db->prepare("INSERT INTO carrinho (usuario_id,jogo_id,quantidade) VALUES(?,?,1) ON DUPLICATE KEY UPDATE quantidade=quantidade+1");
        $s->execute([$uid,$jid]);
    }

    public function remover(int $uid, int $jid): void {
        $s = $this->db->prepare("DELETE FROM carrinho WHERE usuario_id=? AND jogo_id=?");
        $s->execute([$uid,$jid]);
    }

    public function limpar(int $uid): void {
        $s = $this->db->prepare("DELETE FROM carrinho WHERE usuario_id=?");
        $s->execute([$uid]);
    }

    public function total(int $uid): float {
        $itens = $this->getItens($uid);
        $total = 0;
        foreach ($itens as $i) {
            $preco = $i['preco_promocional'] ?? $i['preco'];
            $total += $preco * $i['quantidade'];
        }
        return $total;
    }

    public function jaTemJogo(int $uid, int $jid): bool {
        $s = $this->db->prepare("SELECT id FROM carrinho WHERE usuario_id=? AND jogo_id=?");
        $s->execute([$uid,$jid]);
        return (bool)$s->fetch();
    }
}
