import controller.*;
import util.PreCarga;
import view.*;

import java.util.InputMismatchException;
import java.util.Scanner;

public class Main {

    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);

        // ── Instanciar controllers (MVC) ─────────────────────────────────────
        QuartoController   quartoCtrl   = new QuartoController();
        HospedeController  hospedeCtrl  = new HospedeController();
        ReservaController  reservaCtrl  = new ReservaController();
        RelatorioController relCtrl     = new RelatorioController(quartoCtrl, hospedeCtrl, reservaCtrl);

        // ── Instanciar views ─────────────────────────────────────────────────
        QuartoView   quartoView   = new QuartoView(quartoCtrl, sc);
        HospedeView  hospedeView  = new HospedeView(hospedeCtrl, sc);
        ReservaView  reservaView  = new ReservaView(reservaCtrl, hospedeCtrl, quartoCtrl, sc);
        RelatorioView relView     = new RelatorioView(relCtrl, sc);

        // ── Pre-carga de dados ───────────────────────────────────────────────
        exibirBanner();
        System.out.println("Deseja carregar dados de pre-carga? (s/n): ");
        String resp = sc.nextLine().trim();
        if (resp.equalsIgnoreCase("s")) {
            PreCarga.carregar(quartoCtrl, hospedeCtrl, reservaCtrl);
        }

        // ── Menu principal ───────────────────────────────────────────────────
        int opcao;
        do {
            System.out.println("\n╔══════════════════════════════════════╗");
            System.out.println("║    SISTEMA DE GERENCIAMENTO HOTEL    ║");
            System.out.println("╠══════════════════════════════════════╣");
            System.out.println("║  1 - Gerenciar Quartos               ║");
            System.out.println("║  2 - Gerenciar Hospedes              ║");
            System.out.println("║  3 - Reservas / Check-in / Check-out ║");
            System.out.println("║  4 - Relatorios                      ║");
            System.out.println("║  0 - Sair                            ║");
            System.out.println("╚══════════════════════════════════════╝");
            System.out.print("Opcao: ");
            opcao = lerInt(sc);

            switch (opcao) {
                case 1 -> quartoView.menuQuartos();
                case 2 -> hospedeView.menuHospedes();
                case 3 -> reservaView.menuReservas();
                case 4 -> relView.menuRelatorios();
                case 0 -> System.out.println("\nEncerrando o sistema. Ate logo!");
                default -> System.out.println("Opcao invalida. Tente novamente.");
            }
        } while (opcao != 0);

        sc.close();
    }

    private static void exibirBanner() {
        System.out.println("╔═══════════════════════════════════════════════════╗");
        System.out.println("║                                                   ║");
        System.out.println("║        HOTEL MANAGEMENT SYSTEM  v1.0             ║");
        System.out.println("║                                                   ║");
        System.out.println("║  Padrão MVC | Heranca | Polimorfismo             ║");
        System.out.println("║  Abstracao  | Encapsulamento | Interfaces        ║");
        System.out.println("║                                                   ║");
        System.out.println("╚═══════════════════════════════════════════════════╝");
        System.out.println();
    }

    private static int lerInt(Scanner sc) {
        while (true) {
            try { int v = sc.nextInt(); sc.nextLine(); return v; }
            catch (InputMismatchException e) { sc.nextLine(); System.out.print("Digite um numero inteiro: "); }
        }
    }
}
