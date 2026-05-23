package model;

public class LateReturn {
    private final Loan loan;
    private final long delayDays;

    public LateReturn(Loan loan) {
        if (!loan.isReturned()) throw new IllegalArgumentException("Empréstimo ainda não devolvido.");
        this.loan      = loan;
        this.delayDays = loan.getDelayDays();
    }

    public Loan getLoan()      { return loan; }
    public long getDelayDays() { return delayDays; }

    @Override
    public String toString() {
        return String.format("[ATRASO: %3d dia(s)] %s", delayDays, loan);
    }
}
