<?php
class CarrinhoController extends Controller {
    private CarrinhoModel $m;

    public function __construct() { $this->m = new CarrinhoModel(); }

    public function index(): void {
        $this->requireLogin();
        $itens = $this->m->getItens($_SESSION['uid']);
        $total = $this->m->total($_SESSION['uid']);
        $this->view('carrinho/index', [
            'flash' => $this->getFlash(),
            'itens' => $itens,
            'total' => $total,
            'cc'    => count($itens),
            'csrf'  => $this->csrf(),
        ]);
    }

    public function adicionar(): void {
        $this->requireLogin();
        $this->validateCsrf();
        $jid = (int)($_POST['jogo_id']??0);
        if (!$jid) { $this->redirect('catalogo'); return; }
        $this->m->adicionar($_SESSION['uid'], $jid);
        $this->setFlash('success','Jogo adicionado ao carrinho! 🛒');
        $ref = $_SERVER['HTTP_REFERER'] ?? BASE_URL;
        header("Location: $ref"); exit;
    }

    public function remover(): void {
        $this->requireLogin();
        $this->validateCsrf();
        $jid = (int)($_POST['jogo_id']??0);
        $this->m->remover($_SESSION['uid'], $jid);
        $this->setFlash('success','Item removido.');
        $this->redirect('carrinho');
    }

    public function finalizar(): void {
        $this->requireLogin();
        $this->validateCsrf();
        $itens = $this->m->getItens($_SESSION['uid']);
        if (empty($itens)) { $this->setFlash('danger','Carrinho vazio!'); $this->redirect('carrinho'); return; }
        $total = $this->m->total($_SESSION['uid']);
        $db = Database::getInstance()->getConnection();

        $db->beginTransaction();
        try {
            $db->prepare("INSERT INTO pedidos (usuario_id,total) VALUES(?,?)")->execute([$_SESSION['uid'],$total]);
            $pid = $db->lastInsertId();
            foreach ($itens as $i) {
                $preco = $i['preco_promocional'] ?? $i['preco'];
                $db->prepare("INSERT INTO pedido_itens (pedido_id,jogo_id,quantidade,preco_unitario) VALUES(?,?,?,?)")->execute([$pid,$i['jogo_id'],$i['quantidade'],$preco]);
            }
            $this->m->limpar($_SESSION['uid']);
            $db->commit();
            $this->setFlash('success','Pedido #'.$pid.' realizado com sucesso! 🎉');
            $this->redirect('');
        } catch (Exception $e) {
            $db->rollBack();
            $this->setFlash('danger','Erro ao finalizar pedido.');
            $this->redirect('carrinho');
        }
    }
}
