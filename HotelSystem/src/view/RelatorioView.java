package view;

import controller.RelatorioController;

import java.util.InputMismatchException;
import java.util.Scanner;

public class RelatorioView {
    private final RelatorioController controller;
    private final Scanner sc;

    public RelatorioView(RelatorioController controller, Scanner sc) {
        this.controller = controller;
        this.sc = sc;
    }

    public void menuRelatorios() {
        int opcao;
        do {
            System.out.println("\n╔══════════════════════════════════════╗");
            System.out.println("║            RELATORIOS                ║");
            System.out.println("╠══════════════════════════════════════╣");
            System.out.println("║ 1 - Relatorio geral                  ║");
            System.out.println("║ 2 - Quartos atualmente ocupados      ║");
            System.out.println("║ 3 - Hospedes com atraso (desc.)      ║");
            System.out.println("║ 4 - Quartos mais populares           ║");
            System.out.println("║ 5 - Reservas ativas (detalhado)      ║");
            System.out.println("║ 6 - Historico de check-outs          ║");
            System.out.println("║ 0 - Voltar                           ║");
            System.out.println("╚══════════════════════════════════════╝");
            System.out.print("Opcao: ");
            opcao = lerInt();
            switch (opcao) {
                case 1 -> controller.gerarRelatorioGeral();
                case 2 -> controller.gerarRelatorioQuartosOcupados();
                case 3 -> controller.gerarRelatorioHospedesAtrasados();
                case 4 -> controller.gerarRelatorioQuartosMaisPopulares();
                case 5 -> controller.gerarRelatorioReservasAtivas();
                case 6 -> controller.gerarRelatorioHistoricoCheckouts();
                case 0 -> System.out.println("Voltando...");
                default -> System.out.println("Opcao invalida.");
            }
        } while (opcao != 0);
    }

    private int lerInt() {
        while (true) {
            try { int v = sc.nextInt(); sc.nextLine(); return v; }
            catch (InputMismatchException e) { sc.nextLine(); System.out.print("Digite um numero inteiro: "); }
        }
    }
}
