<?php
class LojaController extends Controller {
    private JogoModel $m;
    private GameCategoriaModel $cm;

    public function __construct() {
        $this->m  = new JogoModel();
        $this->cm = new GameCategoriaModel();
    }

    public function index(): void {
        $destaques  = $this->m->findDestaques();
        $categorias = $this->cm->findAll();
        $todos      = $this->m->findAllAtivos();
        $this->view('loja/home', [
            'flash'     => $this->getFlash(),
            'destaques' => $destaques,
            'categorias'=> $categorias,
            'todos'     => $todos,
            'cc'        => $this->cartCount(),
        ]);
    }

    public function catalogo(): void {
        $cat    = (int)($_GET['cat']??0);
        $busca  = trim($_GET['q']??'');
        $jogos  = $this->m->findAllAtivos($cat,$busca);
        $categorias = $this->cm->findAll();
        $this->view('loja/catalogo', [
            'flash'     => $this->getFlash(),
            'jogos'     => $jogos,
            'categorias'=> $categorias,
            'catAtiva'  => $cat,
            'busca'     => $busca,
            'cc'        => $this->cartCount(),
        ]);
    }

    public function jogo(): void {
        $slug = $_GET['slug'] ?? '';
        $jogo = $this->m->findBySlug($slug);
        if (!$jogo) { $this->redirect('catalogo'); return; }
        $relacionados = $this->m->findAllAtivos((int)$jogo['categoria_id']);
        $relacionados = array_filter($relacionados, fn($j) => $j['id'] != $jogo['id']);
        $relacionados = array_slice($relacionados, 0, 4);
        $this->view('loja/jogo', [
            'flash'      => $this->getFlash(),
            'jogo'       => $jogo,
            'relacionados'=> $relacionados,
            'cc'         => $this->cartCount(),
            'csrf'       => $this->csrf(),
        ]);
    }
}
