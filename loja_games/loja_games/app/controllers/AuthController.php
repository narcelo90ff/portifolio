<?php
class AuthController extends Controller {
    private UsuarioModel $m;
    public function __construct() { $this->m = new UsuarioModel(); }

    public function login(): void {
        if ($this->isLoggedIn()) { $this->redirect(''); return; }
        $this->view('auth/login', ['flash'=>$this->getFlash(),'csrf'=>$this->csrf(),'cc'=>0]);
    }

    public function doLogin(): void {
        $this->validateCsrf();
        $email = trim($_POST['email']??'');
        $senha = $_POST['senha']??'';
        if (!$email||!$senha) { $this->setFlash('danger','Preencha todos os campos.'); $this->redirect('login'); return; }
        $u = $this->m->findByEmail($email);
        if (!$u||!password_verify($senha,$u['senha'])) { $this->setFlash('danger','Email ou senha incorretos.'); $this->redirect('login'); return; }
        session_regenerate_id(true);
        $_SESSION['uid']=$u['id']; $_SESSION['nome']=$u['nome']; $_SESSION['email']=$u['email']; $_SESSION['perfil']=$u['perfil'];
        $this->setFlash('success','Bem-vindo, '.$u['nome'].'! 🎮');
        $this->redirect('');
    }

    public function cadastro(): void {
        if ($this->isLoggedIn()) { $this->redirect(''); return; }
        $this->view('auth/cadastro', ['flash'=>$this->getFlash(),'csrf'=>$this->csrf(),'cc'=>0]);
    }

    public function doCadastro(): void {
        $this->validateCsrf();
        $d = ['nome'=>trim($_POST['nome']??''),'email'=>trim($_POST['email']??''),'cpf'=>trim($_POST['cpf']??''),'data_nascimento'=>$_POST['data_nascimento']??'','senha'=>$_POST['senha']??'','confirmar'=>$_POST['confirmar']??''];
        $erros=[];
        if (!$d['nome']) $erros[]='Nome obrigatório.';
        if (!filter_var($d['email'],FILTER_VALIDATE_EMAIL)) $erros[]='Email inválido.';
        if (!$d['cpf']) $erros[]='CPF obrigatório.';
        if (!$d['data_nascimento']) $erros[]='Data de nascimento obrigatória.';
        if (strlen($d['senha'])<6) $erros[]='Senha mínimo 6 caracteres.';
        if ($d['senha']!==$d['confirmar']) $erros[]='Senhas não coincidem.';
        if ($this->m->findByEmail($d['email'])) $erros[]='Email já cadastrado.';
        if ($this->m->findByCpf($d['cpf'])) $erros[]='CPF já cadastrado.';
        if ($erros) { $this->setFlash('danger',implode('<br>',$erros)); $this->redirect('cadastro'); return; }
        $this->m->create($d);
        $this->setFlash('success','Conta criada! Faça login. 🎉');
        $this->redirect('login');
    }

    public function recuperar(): void {
        $this->view('auth/recuperar', ['flash'=>$this->getFlash(),'csrf'=>$this->csrf(),'cc'=>0]);
    }

    public function doRecuperar(): void {
        $this->validateCsrf();
        $email=$_POST['email']??''; $cpf=$_POST['cpf']??''; $dn=$_POST['data_nascimento']??'';
        $ns=$_POST['nova_senha']??''; $cs=$_POST['confirmar']??'';
        if (strlen($ns)<6) { $this->setFlash('danger','Senha mínimo 6 chars.'); $this->redirect('recuperar'); return; }
        if ($ns!==$cs) { $this->setFlash('danger','Senhas não coincidem.'); $this->redirect('recuperar'); return; }
        $u=$this->m->verificarIdentidade($email,$cpf,$dn);
        if (!$u) { $this->setFlash('danger','Dados não conferem.'); $this->redirect('recuperar'); return; }
        $this->m->updateSenha($u['id'],$ns);
        $this->setFlash('success','Senha alterada! Faça login.');
        $this->redirect('login');
    }

    public function logout(): void {
        $_SESSION=[]; session_destroy();
        $this->redirect('');
    }
}
