<?php
class JogoModel extends Model {
    protected string $table = 'jogos';

    public function findDestaques(): array {
        $s = $this->db->query("SELECT j.*,c.nome cat FROM jogos j LEFT JOIN game_categorias c ON c.id=j.categoria_id WHERE j.destaque=1 AND j.ativo=1 ORDER BY j.id DESC LIMIT 6");
        return $s->fetchAll();
    }

    public function findAllAtivos(int $cat=0, string $busca=''): array {
        $where = ['j.ativo=1'];
        $params = [];
        if ($cat) { $where[] = 'j.categoria_id=?'; $params[] = $cat; }
        if ($busca) { $where[] = '(j.nome LIKE ? OR j.descricao_curta LIKE ?)'; $params[]="%$busca%"; $params[]="%$busca%"; }
        $sql = "SELECT j.*,c.nome cat FROM jogos j LEFT JOIN game_categorias c ON c.id=j.categoria_id WHERE ".implode(' AND ',$where)." ORDER BY j.id DESC";
        $s = $this->db->prepare($sql);
        $s->execute($params);
        return $s->fetchAll();
    }

    public function findBySlug(string $slug): array|false {
        $s = $this->db->prepare("SELECT j.*,c.nome cat FROM jogos j LEFT JOIN game_categorias c ON c.id=j.categoria_id WHERE j.slug=? AND j.ativo=1");
        $s->execute([$slug]);
        return $s->fetch();
    }

    public function findByIdFull(int $id): array|false {
        $s = $this->db->prepare("SELECT j.*,c.nome cat FROM jogos j LEFT JOIN game_categorias c ON c.id=j.categoria_id WHERE j.id=?");
        $s->execute([$id]);
        return $s->fetch();
    }

    public function create(array $d): bool {
        $s = $this->db->prepare("INSERT INTO jogos (nome,slug,descricao,descricao_curta,preco,preco_promocional,plataforma,categoria_id,imagem_url,destaque,estoque) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
        return $s->execute([$d['nome'],$d['slug'],$d['descricao'],$d['descricao_curta'],$d['preco'],$d['preco_promocional']?:null,$d['plataforma'],$d['categoria_id']?:null,$d['imagem_url'],$d['destaque']??0,$d['estoque']??999]);
    }

    public function update(int $id, array $d): bool {
        $s = $this->db->prepare("UPDATE jogos SET nome=?,slug=?,descricao=?,descricao_curta=?,preco=?,preco_promocional=?,plataforma=?,categoria_id=?,imagem_url=?,destaque=?,estoque=? WHERE id=?");
        return $s->execute([$d['nome'],$d['slug'],$d['descricao'],$d['descricao_curta'],$d['preco'],$d['preco_promocional']?:null,$d['plataforma'],$d['categoria_id']?:null,$d['imagem_url'],$d['destaque']??0,$d['estoque']??999,$id]);
    }

    public function makeSlug(string $nome): string {
        $slug = mb_strtolower($nome);
        $slug = preg_replace('/[áàãâä]/u','a',$slug);
        $slug = preg_replace('/[éèêë]/u','e',$slug);
        $slug = preg_replace('/[íìîï]/u','i',$slug);
        $slug = preg_replace('/[óòõôö]/u','o',$slug);
        $slug = preg_replace('/[úùûü]/u','u',$slug);
        $slug = preg_replace('/[ç]/u','c',$slug);
        $slug = preg_replace('/[^a-z0-9]+/','-',$slug);
        return trim($slug,'-');
    }
}
