<?php
class UsuarioModel extends Model {
    protected string $table = 'usuarios';

    public function findByEmail(string $email): array|false {
        $s = $this->db->prepare("SELECT * FROM usuarios WHERE email=? AND ativo=1");
        $s->execute([$email]); return $s->fetch();
    }
    public function findByCpf(string $cpf): array|false {
        $s = $this->db->prepare("SELECT * FROM usuarios WHERE cpf=?");
        $s->execute([$cpf]); return $s->fetch();
    }
    public function create(array $d): bool {
        $s = $this->db->prepare("INSERT INTO usuarios (nome,email,cpf,data_nascimento,senha,perfil) VALUES(?,?,?,?,?,?)");
        return $s->execute([$d['nome'],$d['email'],$d['cpf'],$d['data_nascimento'],password_hash($d['senha'],PASSWORD_BCRYPT),$d['perfil']??'usuario']);
    }
    public function verificarIdentidade(string $email, string $cpf, string $dn): array|false {
        $s = $this->db->prepare("SELECT * FROM usuarios WHERE email=? AND cpf=? AND data_nascimento=?");
        $s->execute([$email,$cpf,$dn]); return $s->fetch();
    }
    public function updateSenha(int $id, string $senha): bool {
        $s = $this->db->prepare("UPDATE usuarios SET senha=? WHERE id=?");
        return $s->execute([password_hash($senha,PASSWORD_BCRYPT),$id]);
    }
}
