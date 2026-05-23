package view;

import controller.BookController;
import model.Book;

import java.util.List;

public class BookView {
    private final BookController ctrl;

    public BookView(BookController ctrl) { this.ctrl = ctrl; }

    public void menu() {
        boolean running = true;
        while (running) {
            ConsoleView.header("GERENCIAR LIVROS");
            System.out.println("  1. Cadastrar Livro");
            System.out.println("  2. Listar Todos os Livros");
            System.out.println("  3. Buscar Livro");
            System.out.println("  4. Remover Livro");
            System.out.println("  0. Voltar");

            int opt = ConsoleView.readInt("\n  Opção: ");
            switch (opt) {
                case 1 -> cadastrar();
                case 2 -> listar();
                case 3 -> buscar();
                case 4 -> remover();
                case 0 -> running = false;
                default -> ConsoleView.err("Opção inválida.");
            }
            if (running && opt != 0) ConsoleView.pause();
        }
    }

    private void cadastrar() {
        ConsoleView.header("CADASTRAR LIVRO");
        try {
            String title    = ConsoleView.readString("  Título:             ");
            String author   = ConsoleView.readString("  Autor:              ");
            int    year     = ConsoleView.readInt   ("  Ano de publicação:  ");
            String category = ConsoleView.readString("  Categoria:          ");
            int    copies   = ConsoleView.readInt   ("  Nº de exemplares:   ");
            Book b = ctrl.add(title, author, year, category, copies);
            ConsoleView.ok("Livro cadastrado! ID: " + b.getId());
        } catch (IllegalArgumentException e) {
            ConsoleView.err(e.getMessage());
        }
    }

    private void listar() {
        ConsoleView.header("ACERVO DE LIVROS");
        List<Book> books = ctrl.getAll();
        if (books.isEmpty()) { ConsoleView.info("Nenhum livro cadastrado."); return; }
        books.forEach(b -> System.out.println("  " + b));
    }

    private void buscar() {
        ConsoleView.header("BUSCAR LIVRO");
        System.out.println("  1. Por Código");
        System.out.println("  2. Por Título");
        System.out.println("  3. Por Autor");
        System.out.println("  4. Por Categoria");
        int opt = ConsoleView.readInt("\n  Opção: ");

        switch (opt) {
            case 1 -> {
                int id = ConsoleView.readInt("  ID: ");
                Book b = ctrl.searchById(id);
                if (b == null) ConsoleView.info("Livro não encontrado.");
                else System.out.println("  " + b);
            }
            case 2 -> printList(ctrl.searchByTitle(ConsoleView.readString("  Título: ")));
            case 3 -> printList(ctrl.searchByAuthor(ConsoleView.readString("  Autor: ")));
            case 4 -> printList(ctrl.searchByCategory(ConsoleView.readString("  Categoria: ")));
            default -> ConsoleView.err("Opção inválida.");
        }
    }

    private void remover() {
        ConsoleView.header("REMOVER LIVRO");
        int id = ConsoleView.readInt("  ID do livro: ");
        Book b = ctrl.searchById(id);
        if (b == null) { ConsoleView.err("Livro não encontrado."); return; }
        System.out.println("\n  " + b);
        if (!ConsoleView.readString("\n  Confirmar remoção? (s/n): ").equalsIgnoreCase("s")) return;
        try {
            if (ctrl.remove(id)) ConsoleView.ok("Livro removido com sucesso.");
            else ConsoleView.err("Não foi possível remover o livro.");
        } catch (IllegalStateException e) {
            ConsoleView.err(e.getMessage());
        }
    }

    private void printList(List<Book> books) {
        if (books.isEmpty()) ConsoleView.info("Nenhum livro encontrado.");
        else books.forEach(b -> System.out.println("  " + b));
    }
}
