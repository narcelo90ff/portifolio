package model;

import java.time.LocalDate;
import java.time.temporal.ChronoUnit;

public class Loan {
    private static int counter = 1;

    private final int       id;
    private final Book      book;
    private final User      user;
    private final LocalDate loanDate;
    private final LocalDate expectedReturnDate;
    private       LocalDate actualReturnDate;
    private       boolean   returned;

    public static final int DEFAULT_LOAN_DAYS = 14;

    public Loan(Book book, User user, LocalDate loanDate, int loanDays) {
        this.id                 = counter++;
        this.book               = book;
        this.user               = user;
        this.loanDate           = loanDate;
        this.expectedReturnDate = loanDate.plusDays(loanDays);
        this.returned           = false;
    }

    public int       getId()                  { return id; }
    public Book      getBook()                { return book; }
    public User      getUser()                { return user; }
    public LocalDate getLoanDate()            { return loanDate; }
    public LocalDate getExpectedReturnDate()  { return expectedReturnDate; }
    public LocalDate getActualReturnDate()    { return actualReturnDate; }
    public boolean   isReturned()             { return returned; }

    public void returnBook(LocalDate returnDate) {
        if (returned) throw new IllegalStateException("Este empréstimo já foi devolvido.");
        this.actualReturnDate = returnDate;
        this.returned         = true;
    }

    /** Dias de atraso após devolução (0 se não houve atraso). */
    public long getDelayDays() {
        if (!returned) return 0;
        long d = ChronoUnit.DAYS.between(expectedReturnDate, actualReturnDate);
        return Math.max(d, 0);
    }

    /** Dias de atraso considerando hoje (para empréstimos ainda ativos). */
    public long getCurrentDelayDays() {
        if (returned) return getDelayDays();
        long d = ChronoUnit.DAYS.between(expectedReturnDate, LocalDate.now());
        return Math.max(d, 0);
    }

    public boolean isLate() {
        if (returned) return getDelayDays() > 0;
        return LocalDate.now().isAfter(expectedReturnDate);
    }

    @Override
    public String toString() {
        if (returned) {
            long days = ChronoUnit.DAYS.between(loanDate, actualReturnDate);
            String delay = getDelayDays() > 0 ? String.format("  ⚠ ATRASO: %d dias", getDelayDays()) : "  ✓ No prazo";
            return String.format("[Emp.#%d] Livro: %-30s | Usuário: %-20s | Emprestado: %s | Devolvido: %s (%d dias)%s",
                    id, book.getTitle(), user.getName(), loanDate, actualReturnDate, days, delay);
        } else {
            String atraso = isLate()
                    ? String.format("  *** ATRASADO há %d dia(s) ***", getCurrentDelayDays())
                    : "";
            return String.format("[Emp.#%d] Livro: %-30s | Usuário: %-20s | Emprestado: %s | Devolução prevista: %s%s",
                    id, book.getTitle(), user.getName(), loanDate, expectedReturnDate, atraso);
        }
    }
}
