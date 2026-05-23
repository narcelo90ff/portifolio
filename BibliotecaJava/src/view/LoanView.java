package view;

import controller.BookController;
import controller.LoanController;
import controller.UserController;
import model.Book;
import model.Loan;
import model.LateReturn;
import model.User;

import java.time.temporal.ChronoUnit;
import java.util.List;

public class LoanView {
    private final LoanController loanCtrl;
    private final BookController bookCtrl;
    private final UserController userCtrl;

    public LoanView(LoanController lc, BookController bc, UserController uc) {
        this.loanCtrl = lc;
        this.bookCtrl = bc;
        this.userCtrl = uc;
    }

    public void menu() {
        boolean running = true;
        while (running) {
            ConsoleView.header("EMPRÉSTIMOS E DEVOLUÇÕES");
            System.out.println("  1. Realizar Empréstimo");
            System.out.println("  2. Realizar Devolução");
            System.out.println("  3. Listar Empréstimos Ativos");
            System.out.println("  4. Listar Empréstimos em Atraso");
            System.out.println("  5. Histórico de Devoluções com Atraso");
            System.out.println("  0. Voltar");

            int opt = ConsoleView.readInt("\n  Opção: ");
            switch (opt) {
                case 1 -> emprestar();
                case 2 -> devolver();
                case 3 -> listarAtivos();
                case 4 -> listarAtrasados();
                case 5 -> historicoAtrasos();
                case 0 -> running = false;
                default -> ConsoleView.err("Opção inválida.");
            }
            if (running && opt != 0) ConsoleView.pause();
        }
    }

    private void emprestar() {
        ConsoleView.header("REALIZAR EMPRÉSTIMO");
        int userId = ConsoleView.readInt("  ID do usuário: ");
        User user  = userCtrl.findById(userId);
        if (user == null) { ConsoleView.err("Usuário não encontrado."); return; }

        int  bookId = ConsoleView.readInt("  ID do livro:   ");
        Book book   = bookCtrl.searchById(bookId);
        if (book == null) { ConsoleView.err("Livro não encontrado."); return; }

        try {
            Loan loan = loanCtrl.createLoan(book, user);
            ConsoleView.ok("Empréstimo realizado com sucesso!");
            System.out.println("\n  " + loan);
            System.out.println("  Prazo de devolução: " + loan.getExpectedReturnDate()
                    + " (" + Loan.DEFAULT_LOAN_DAYS + " dias)");
        } catch (IllegalStateException e) {
            ConsoleView.err(e.getMessage());
        }
    }

    private void devolver() {
        ConsoleView.header("REALIZAR DEVOLUÇÃO");
        int  userId = ConsoleView.readInt("  ID do usuário: ");
        User user   = userCtrl.findById(userId);
        if (user == null) { ConsoleView.err("Usuário não encontrado."); return; }

        Loan loan = loanCtrl.findActiveLoanByUser(user);
        if (loan == null) { ConsoleView.err("Usuário não possui empréstimo ativo."); return; }

        System.out.println("\n  Empréstimo encontrado:");
        System.out.println("  " + loan);
        if (!ConsoleView.readString("\n  Confirmar devolução? (s/n): ").equalsIgnoreCase("s")) return;

        try {
            Loan returned = loanCtrl.returnBook(loan.getId());
            long totalDays = ChronoUnit.DAYS.between(returned.getLoanDate(), returned.getActualReturnDate());
            ConsoleView.ok("Livro devolvido! Total de dias emprestado: " + totalDays);
            if (returned.getDelayDays() > 0) {
                System.out.println("  ⚠  Devolução com atraso de " + returned.getDelayDays() + " dia(s)!");
            } else {
                System.out.println("  ✓  Devolução dentro do prazo.");
            }
        } catch (Exception e) {
            ConsoleView.err(e.getMessage());
        }
    }

    private void listarAtivos() {
        ConsoleView.header("EMPRÉSTIMOS ATIVOS");
        List<Loan> loans = loanCtrl.getActiveLoans();
        if (loans.isEmpty()) { ConsoleView.info("Nenhum empréstimo ativo."); return; }
        loans.forEach(l -> System.out.println("  " + l));
    }

    private void listarAtrasados() {
        ConsoleView.header("EMPRÉSTIMOS EM ATRASO");
        List<Loan> late = loanCtrl.getLateActiveLoans();
        if (late.isEmpty()) { ConsoleView.info("Nenhum empréstimo em atraso."); return; }
        late.forEach(l -> System.out.println("  " + l));
    }

    private void historicoAtrasos() {
        ConsoleView.header("HISTÓRICO — DEVOLUÇÕES COM ATRASO (ordem decrescente)");
        List<LateReturn> history = loanCtrl.getLateReturns();
        if (history.isEmpty()) { ConsoleView.info("Nenhuma devolução com atraso registrada."); return; }
        history.forEach(lr -> System.out.println("  " + lr));
    }
}
