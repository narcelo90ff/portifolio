package view;

import controller.HospedeController;
import controller.QuartoController;
import controller.ReservaController;
import model.Hospede;
import model.Quarto;
import model.Reserva;

import java.time.LocalDate;
import java.time.format.DateTimeFormatter;
import java.time.format.DateTimeParseException;
import java.util.InputMismatchException;
import java.util.List;
import java.util.Scanner;

public class ReservaView {
    private final ReservaController  reservaCtrl;
    private final HospedeController  hospedeCtrl;
    private final QuartoController   quartoCtrl;
    private final Scanner sc;
    private static final DateTimeFormatter FMT = DateTimeFormatter.ofPattern("dd/MM/yyyy");

    public ReservaView(ReservaController rc, HospedeController hc, QuartoController qc, Scanner sc) {
        this.reservaCtrl = rc;
        this.hospedeCtrl = hc;
        this.quartoCtrl  = qc;
        this.sc = sc;
    }

    public void menuReservas() {
        int opcao;
        do {
            System.out.println("\n╔══════════════════════════════╗");
            System.out.println("║    GESTAO DE RESERVAS        ║");
            System.out.println("╠══════════════════════════════╣");
            System.out.println("║ 1 - Nova reserva (check-in)  ║");
            System.out.println("║ 2 - Realizar check-out       ║");
            System.out.println("║ 3 - Listar reservas ativas   ║");
            System.out.println("║ 4 - Listar todas as reservas ║");
            System.out.println("║ 5 - Buscar reserva por ID    ║");
            System.out.println("║ 0 - Voltar                   ║");
            System.out.println("╚══════════════════════════════╝");
            System.out.print("Opcao: ");
            opcao = lerInt();
            switch (opcao) {
                case 1 -> novaReserva();
                case 2 -> realizarCheckOut();
                case 3 -> listarAtivas();
                case 4 -> listarTodas();
                case 5 -> buscarPorId();
                case 0 -> System.out.println("Voltando...");
                default -> System.out.println("Opcao invalida.");
            }
        } while (opcao != 0);
    }

    private void novaReserva() {
        System.out.println("\n--- NOVA RESERVA ---");
        System.out.print("ID do hospede  : ");
        int hospedeId = lerInt();
        Hospede h = hospedeCtrl.buscarPorCodigo(hospedeId);
        if (h == null) { System.out.println("Hospede nao encontrado."); return; }

        System.out.print("Numero do quarto: ");
        int quartoNum = lerInt();
        Quarto q = quartoCtrl.buscarPorCodigo(quartoNum);
        if (q == null) { System.out.println("Quarto nao encontrado."); return; }

        System.out.print("Data check-in  (dd/MM/yyyy): ");
        LocalDate checkIn = lerData();
        if (checkIn == null) return;

        System.out.print("Data check-out (dd/MM/yyyy): ");
        LocalDate checkOut = lerData();
        if (checkOut == null) return;

        try {
            Reserva r = reservaCtrl.realizarReserva(h, q, checkIn, checkOut);
            long noites = r.getDiasHospedagem();
            System.out.println("\nReserva realizada com sucesso!");
            System.out.println("  " + r);
            System.out.printf("  Hospede: %s | Quarto %d (%s)%n",
                    h.getNome(), q.getNumero(), q.getTipoQuarto());
            System.out.printf("  Duracao: %d noite(s) | Valor estimado: R$ %.2f%n",
                    noites, r.getValorTotal());
        } catch (Exception e) {
            System.out.println("ERRO: " + e.getMessage());
        }
    }

    private void realizarCheckOut() {
        System.out.println("\n--- CHECK-OUT ---");
        System.out.print("ID da reserva: ");
        int reservaId = lerInt();

        Reserva r = reservaCtrl.buscarPorId(reservaId);
        if (r == null) { System.out.println("Reserva nao encontrada."); return; }

        System.out.println("Reserva encontrada: " + r);
        System.out.print("Data efetiva de check-out (dd/MM/yyyy) [ENTER = hoje]: ");
        String entrada = sc.nextLine().trim();
        LocalDate dataEfetiva;
        if (entrada.isEmpty()) {
            dataEfetiva = LocalDate.now();
        } else {
            dataEfetiva = parsarData(entrada);
            if (dataEfetiva == null) return;
        }

        try {
            reservaCtrl.realizarCheckOut(reservaId, dataEfetiva);
            System.out.println("\nCheck-out realizado com sucesso!");
            System.out.printf("  Hospede : %s%n", r.getHospede().getNome());
            System.out.printf("  Quarto  : %d%n", r.getQuarto().getNumero());
            System.out.printf("  Noites  : %d%n", r.getDiasHospedagem());
            System.out.printf("  Total   : R$ %.2f%n", r.getValorTotal());
            if (r.temAtraso()) {
                System.out.printf("  ATRASO  : %d dia(s)!%n", r.getDiasAtraso());
            } else {
                System.out.println("  Devolucao realizada no prazo.");
            }
        } catch (Exception e) {
            System.out.println("ERRO: " + e.getMessage());
        }
    }

    private void listarAtivas() {
        List<Reserva> lista = reservaCtrl.listarAtivas();
        System.out.println("\n--- RESERVAS ATIVAS (" + lista.size() + ") ---");
        if (lista.isEmpty()) { System.out.println("Nenhuma reserva ativa."); return; }
        for (Reserva r : lista) {
            System.out.println("  " + r);
            System.out.printf("    Valor estimado: R$ %.2f%n", r.getValorTotal());
        }
    }

    private void listarTodas() {
        List<Reserva> lista = reservaCtrl.listarTodas();
        System.out.println("\n--- TODAS AS RESERVAS (" + lista.size() + ") ---");
        if (lista.isEmpty()) { System.out.println("Nenhuma reserva registrada."); return; }
        for (Reserva r : lista) System.out.println("  " + r);
    }

    private void buscarPorId() {
        System.out.print("ID da reserva: ");
        int id = lerInt();
        Reserva r = reservaCtrl.buscarPorId(id);
        if (r == null) { System.out.println("Reserva nao encontrada."); return; }
        System.out.println("  " + r);
        if (r.getDataCheckOutEfetiva() != null) {
            System.out.printf("  Check-out efetivo: %s | Noites: %d | Total: R$ %.2f%n",
                    r.getDataCheckOutEfetiva(), r.getDiasHospedagem(), r.getValorTotal());
            if (r.temAtraso()) System.out.printf("  ATRASO: %d dia(s)%n", r.getDiasAtraso());
        }
    }

    private LocalDate lerData() {
        String s = sc.nextLine().trim();
        return parsarData(s);
    }

    private LocalDate parsarData(String s) {
        try {
            return LocalDate.parse(s, FMT);
        } catch (DateTimeParseException e) {
            System.out.println("Data invalida. Use o formato dd/MM/yyyy.");
            return null;
        }
    }

    private int lerInt() {
        while (true) {
            try { int v = sc.nextInt(); sc.nextLine(); return v; }
            catch (InputMismatchException e) { sc.nextLine(); System.out.print("Digite um numero inteiro: "); }
        }
    }
}
