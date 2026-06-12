<?php
class GameCategoriaModel extends Model {
    protected string $table = 'game_categorias';
    public function create(array $d): bool {
        $s = $this->db->prepare("INSERT INTO game_categorias (nome,slug,icone) VALUES(?,?,?)");
        return $s->execute([$d['nome'],$d['slug'],$d['icone']??'🎮']);
    }
    public function update(int $id, array $d): bool {
        $s = $this->db->prepare("UPDATE game_categorias SET nome=?,slug=?,icone=? WHERE id=?");
        return $s->execute([$d['nome'],$d['slug'],$d['icone']??'🎮',$id]);
    }
}
