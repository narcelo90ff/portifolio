package view;

public class MenuView {
    private final BookView   bookView;
    private final UserView   userView;
    private final LoanView   loanView;
    private final ReportView reportView;

    public MenuView(BookView bv, UserView uv, LoanView lv, ReportView rv) {
        this.bookView   = bv;
        this.userView   = uv;
        this.loanView   = lv;
        this.reportView = rv;
    }

    public void run() {
        System.out.println();
        System.out.println("  ╔══════════════════════════════════════════════╗");
        System.out.println("  ║   SISTEMA DE GERENCIAMENTO DE BIBLIOTECA     ║");
        System.out.println("  ║          Universidade de Pernambuco          ║");
        System.out.println("  ╚══════════════════════════════════════════════╝");

        boolean running = true;
        while (running) {
            ConsoleView.header("MENU PRINCIPAL");
            System.out.println("  1. Gerenciar Livros");
            System.out.println("  2. Gerenciar Usuários");
            System.out.println("  3. Empréstimos e Devoluções");
            System.out.println("  4. Relatórios");
            System.out.println("  0. Sair");

            int opt = ConsoleView.readInt("\n  Opção: ");
            switch (opt) {
                case 1 -> bookView.menu();
                case 2 -> userView.menu();
                case 3 -> loanView.menu();
                case 4 -> reportView.menu();
                case 0 -> {
                    running = false;
                    System.out.println("\n  Encerrando o sistema. Até mais!\n");
                }
                default -> ConsoleView.err("Opção inválida. Escolha entre 0 e 4.");
            }
        }
        ConsoleView.close();
    }
}
