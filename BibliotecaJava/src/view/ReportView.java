package view;

import controller.ReportController;

public class ReportView {
    private final ReportController ctrl;

    public ReportView(ReportController ctrl) { this.ctrl = ctrl; }

    public void menu() {
        boolean running = true;
        while (running) {
            ConsoleView.header("RELATÓRIOS");
            System.out.println("  1. Livros Atualmente Emprestados");
            System.out.println("  2. Usuários com Devolução em Atraso");
            System.out.println("  3. Top 5 Livros Mais Populares");
            System.out.println("  4. Histórico de Devoluções com Atraso");
            System.out.println("  5. Acervo Completo");
            System.out.println("  6. Todos os Usuários");
            System.out.println("  7. Histórico Completo de Empréstimos");
            System.out.println("  0. Voltar");

            int opt = ConsoleView.readInt("\n  Opção: ");
            switch (opt) {
                case 1 -> ctrl.reportCurrentLoans();
                case 2 -> ctrl.reportLateUsers();
                case 3 -> ctrl.reportMostPopularBooks();
                case 4 -> ctrl.reportLateReturns();
                case 5 -> ctrl.reportAllBooks();
                case 6 -> ctrl.reportAllUsers();
                case 7 -> ctrl.reportAllLoans();
                case 0 -> running = false;
                default -> ConsoleView.err("Opção inválida.");
            }
            if (running && opt != 0) ConsoleView.pause();
        }
    }
}
