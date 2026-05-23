package controller;

import model.*;

import java.time.LocalDate;
import java.util.*;
import java.util.stream.Collectors;

public class LoanController {
    private final List<Loan>       loans       = new ArrayList<>();
    private final List<LateReturn> lateReturns = new ArrayList<>();

    // ── Operações principais ─────────────────────────────────────────────────

    public Loan createLoan(Book book, User user) {
        if (book == null)  throw new IllegalArgumentException("Livro não encontrado.");
        if (user == null)  throw new IllegalArgumentException("Usuário não encontrado.");
        if (!book.isAvailable())
            throw new IllegalStateException("Nenhum exemplar disponível para o livro: " + book.getTitle());
        if (user.hasActiveLoan())
            throw new IllegalStateException("Usuário \"" + user.getName() + "\" já possui um livro emprestado.");

        book.lend();
        user.setHasActiveLoan(true);
        Loan loan = new Loan(book, user, LocalDate.now(), Loan.DEFAULT_LOAN_DAYS);
        loans.add(loan);
        return loan;
    }

    public Loan returnBook(int loanId) {
        Loan loan = findActiveLoanById(loanId);
        if (loan == null)
            throw new IllegalArgumentException("Empréstimo ativo não encontrado com ID: " + loanId);

        loan.returnBook(LocalDate.now());
        loan.getBook().returnCopy();
        loan.getUser().setHasActiveLoan(false);

        if (loan.isLate()) {
            lateReturns.add(new LateReturn(loan));
            lateReturns.sort(Comparator.comparingLong(LateReturn::getDelayDays).reversed());
        }
        return loan;
    }

    /** Usado pelo DataPreloader para inserir empréstimos históricos já finalizados. */
    public void registerHistoricalLoan(Loan loan) {
        loans.add(loan);
        if (loan.isReturned() && loan.isLate()) {
            lateReturns.add(new LateReturn(loan));
            lateReturns.sort(Comparator.comparingLong(LateReturn::getDelayDays).reversed());
        }
    }

    /** Usado pelo DataPreloader para inserir empréstimos ativos com data retroativa. */
    public void registerActiveLoan(Loan loan) {
        loans.add(loan);
    }

    // ── Consultas ─────────────────────────────────────────────────────────────

    public Loan findActiveLoanById(int id) {
        return loans.stream().filter(l -> l.getId() == id && !l.isReturned()).findFirst().orElse(null);
    }

    public Loan findActiveLoanByUser(User user) {
        return loans.stream()
                .filter(l -> l.getUser().getId() == user.getId() && !l.isReturned())
                .findFirst().orElse(null);
    }

    public List<Loan> getActiveLoans() {
        return loans.stream().filter(l -> !l.isReturned()).collect(Collectors.toList());
    }

    public List<Loan> getAllLoans() {
        return Collections.unmodifiableList(loans);
    }

    public List<LateReturn> getLateReturns() {
        return Collections.unmodifiableList(lateReturns);
    }

    public List<Loan> getLateActiveLoans() {
        return loans.stream()
                .filter(l -> !l.isReturned() && l.isLate())
                .sorted(Comparator.comparingLong(Loan::getCurrentDelayDays).reversed())
                .collect(Collectors.toList());
    }

    public List<Book> getMostPopularBooks(List<Book> allBooks, int limit) {
        return allBooks.stream()
                .sorted(Comparator.comparingInt(Book::getLoanCount).reversed())
                .limit(limit)
                .collect(Collectors.toList());
    }
}
