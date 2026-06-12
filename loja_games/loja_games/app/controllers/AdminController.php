<?php
class AdminController extends Controller {
    private JogoModel $jm;
    private GameCategoriaModel $cm;

    public function __construct() {
        $this->jm = new JogoModel();
        $this->cm = new GameCategoriaModel();
    }

    public function dashboard(): void {
        $this->requireAdmin();
        $db = Database::getInstance()->getConnection();
        $stats = [
            'jogos'    => $this->jm->count(),
            'usuarios' => (int)$db->query("SELECT COUNT(*) FROM usuarios")->fetchColumn(),
            'pedidos'  => (int)$db->query("SELECT COUNT(*) FROM pedidos")->fetchColumn(),
            'receita'  => (float)$db->query("SELECT COALESCE(SUM(total),0) FROM pedidos WHERE status='pago'")->fetchColumn(),
        ];
        $pedidos = $db->query("SELECT p.*,u.nome FROM pedidos p JOIN usuarios u ON u.id=p.usuario_id ORDER BY p.id DESC LIMIT 10")->fetchAll();
        $this->view('admin/dashboard', ['flash'=>$this->getFlash(),'stats'=>$stats,'pedidos'=>$pedidos,'cc'=>0]);
    }

    /* ── Jogos ── */
    public function jogos(): void {
        $this->requireAdmin();
        $this->view('admin/jogos', ['flash'=>$this->getFlash(),'jogos'=>$this->jm->findAll(),'cc'=>0,'csrf'=>$this->csrf()]);
    }

    public function jogoForm(): void {
        $this->requireAdmin();
        $id   = (int)($_GET['id']??0);
        $jogo = $id ? $this->jm->findByIdFull($id) : null;
        $this->view('admin/jogo_form', ['flash'=>$this->getFlash(),'jogo'=>$jogo,'categorias'=>$this->cm->findAll(),'cc'=>0,'csrf'=>$this->csrf()]);
    }

    public function jogoSalvar(): void {
        $this->requireAdmin();
        $this->validateCsrf();
        $id = (int)($_POST['id']??0);
        $d  = [
            'nome'           => trim($_POST['nome']??''),
            'slug'           => $this->jm->makeSlug($_POST['nome']??''),
            'descricao'      => trim($_POST['descricao']??''),
            'descricao_curta'=> trim($_POST['descricao_curta']??''),
            'preco'          => str_replace(',','.',$_POST['preco']??'0'),
            'preco_promocional'=> $_POST['preco_promocional']?str_replace(',','.',$_POST['preco_promocional']):null,
            'plataforma'     => trim($_POST['plataforma']??'PC'),
            'categoria_id'   => (int)($_POST['categoria_id']??0),
            'imagem_url'     => trim($_POST['imagem_url']??''),
            'destaque'       => isset($_POST['destaque'])?1:0,
            'estoque'        => (int)($_POST['estoque']??999),
        ];
        if (!$d['nome']) { $this->setFlash('danger','Nome obrigatório.'); $this->redirect('admin/jogo?id='.$id); return; }
        $id ? $this->jm->update($id,$d) : $this->jm->create($d);
        $this->setFlash('success','Jogo salvo!');
        $this->redirect('admin/jogos');
    }

    public function jogoDeletar(): void {
        $this->requireAdmin();
        $this->validateCsrf();
        $this->jm->delete((int)($_POST['id']??0));
        $this->setFlash('success','Jogo removido.');
        $this->redirect('admin/jogos');
    }

    /* ── Categorias ── */
    public function categorias(): void {
        $this->requireAdmin();
        $this->view('admin/categorias', ['flash'=>$this->getFlash(),'categorias'=>$this->cm->findAll(),'cc'=>0,'csrf'=>$this->csrf()]);
    }

    public function catForm(): void {
        $this->requireAdmin();
        $id  = (int)($_GET['id']??0);
        $cat = $id ? $this->cm->findById($id) : null;
        $this->view('admin/cat_form', ['flash'=>$this->getFlash(),'cat'=>$cat,'cc'=>0,'csrf'=>$this->csrf()]);
    }

    public function catSalvar(): void {
        $this->requireAdmin();
        $this->validateCsrf();
        $id = (int)($_POST['id']??0);
        $d  = ['nome'=>trim($_POST['nome']??''),'slug'=>trim($_POST['slug']??''),'icone'=>trim($_POST['icone']??'🎮')];
        $id ? $this->cm->update($id,$d) : $this->cm->create($d);
        $this->setFlash('success','Categoria salva!');
        $this->redirect('admin/categorias');
    }

    public function catDeletar(): void {
        $this->requireAdmin();
        $this->validateCsrf();
        $this->cm->delete((int)($_POST['id']??0));
        $this->setFlash('success','Categoria removida.');
        $this->redirect('admin/categorias');
    }

    public function pedidos(): void {
        $this->requireAdmin();
        $db = Database::getInstance()->getConnection();
        $pedidos = $db->query("SELECT p.*,u.nome FROM pedidos p JOIN usuarios u ON u.id=p.usuario_id ORDER BY p.id DESC")->fetchAll();
        $this->view('admin/pedidos', ['flash'=>$this->getFlash(),'pedidos'=>$pedidos,'cc'=>0,'csrf'=>$this->csrf()]);
    }

    public function pedidoStatus(): void {
        $this->requireAdmin();
        $this->validateCsrf();
        $id=$_POST['id']??0; $status=$_POST['status']??'pendente';
        $db=Database::getInstance()->getConnection();
        $db->prepare("UPDATE pedidos SET status=? WHERE id=?")->execute([$status,$id]);
        $this->setFlash('success','Status atualizado.');
        $this->redirect('admin/pedidos');
    }
}
