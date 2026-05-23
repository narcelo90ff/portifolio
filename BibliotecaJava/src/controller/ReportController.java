package controller;

import interfaces.Reportable;
import model.*;

import java.util.List;

// Polimorfismo via interface: ReportController implementa Reportable
public class ReportController implements Reportable {
    private final BookController bookController;
    private final UserController userController;
    private final LoanController loanController;

    public ReportController(BookController b, UserController u, LoanController l) {
        this.bookController = b;
        this.userController = u;
        this.loanController = l;
    }

    @Override
    public void reportCurrentLoans() {
        List<Loan> active = loanController.getActiveLoans();
        header("LIVROS ATUALMENTE EMPRESTADOS (" + active.size() + ")");
        if (active.isEmpty()) { System.out.println("  Nenhum empréstimo ativo."); return; }
        active.forEach(l -> System.out.println("  " + l));
    }

    @Override
    public void reportLateUsers() {
        List<Loan> late = loanController.getLateActiveLoans();
        header("USUÁRIOS COM DEVOLUÇÃO EM ATRASO (" + late.size() + ")");
        if (late.isEmpty()) { System.out.println("  Nenhum usuário em atraso."); return; }
        late.forEach(l -> System.out.printf("  %-25s | Livro: %-30s | Atraso: %d dia(s)%n",
                l.getUser().getName(), l.getBook().getTitle(), l.getCurrentDelayDays()));
    }

    @Override
    public void reportMostPopularBooks() {
        List<Book> popular = loanController.getMostPopularBooks(bookController.getAll(), 5);
        header("TOP 5 LIVROS MAIS POPULARES");
        if (popular.isEmpty()) { System.out.println("  Nenhum livro cadastrado."); return; }
        int rank = 1;
        for (Book b : popular) {
            System.out.printf("  %d. %-40s | %d empréstimo(s)%n", rank++, b.getTitle(), b.getLoanCount());
        }
    }

    @Override
    public void reportLateReturns() {
        List<LateReturn> history = loanController.getLateReturns();
        header("HISTÓRICO DE DEVOLUÇÕES COM ATRASO — ordem decrescente (" + history.size() + ")");
        if (history.isEmpty()) { System.out.println("  Nenhuma devolução com atraso registrada."); return; }
        history.forEach(lr -> System.out.println("  " + lr));
    }

    public void reportAllBooks() {
        List<Book> books = bookController.getAll();
        header("ACERVO COMPLETO (" + books.size() + " livros)");
        if (books.isEmpty()) { System.out.println("  Nenhum livro cadastrado."); return; }
        books.forEach(b -> System.out.println("  " + b));
    }

    public void reportAllUsers() {
        List<User> users = userController.getAll();
        header("USUÁRIOS CADASTRADOS (" + users.size() + ")");
        if (users.isEmpty()) { System.out.println("  Nenhum usuário cadastrado."); return; }
        users.forEach(u -> System.out.println("  " + u));
    }

    public void reportAllLoans() {
        List<Loan> loans = loanController.getAllLoans();
        header("HISTÓRICO COMPLETO DE EMPRÉSTIMOS (" + loans.size() + ")");
        if (loans.isEmpty()) { System.out.println("  Nenhum empréstimo registrado."); return; }
        loans.forEach(l -> System.out.println("  " + l));
    }

    private void header(String title) {
        System.out.println("\n" + "─".repeat(70));
        System.out.println("  " + title);
        System.out.println("─".repeat(70));
    }
}
