package controller;

import interfaces.Relatoravel;
import model.Hospede;
import model.Quarto;
import model.Reserva;

import java.util.List;

public class RelatorioController implements Relatoravel {
    private final QuartoController   quartoCtrl;
    private final HospedeController  hospedeCtrl;
    private final ReservaController  reservaCtrl;

    public RelatorioController(QuartoController qc, HospedeController hc, ReservaController rc) {
        this.quartoCtrl  = qc;
        this.hospedeCtrl = hc;
        this.reservaCtrl = rc;
    }

    @Override
    public void gerarRelatorio() {
        gerarRelatorioGeral();
    }

    public void gerarRelatorioGeral() {
        List<Quarto>  todos      = quartoCtrl.listarTodos();
        List<Quarto>  disponiveis= quartoCtrl.listarDisponiveis();
        List<Hospede> hospedes   = hospedeCtrl.listarTodos();
        List<Reserva> ativas     = reservaCtrl.listarAtivas();
        List<Reserva> atrasadas  = reservaCtrl.listarAtrasadas();

        System.out.println("\n============================================================");
        System.out.println("               RELATORIO GERAL DO HOTEL                    ");
        System.out.println("============================================================");
        System.out.printf("  Total de quartos       : %d%n", todos.size());
        System.out.printf("  Quartos disponiveis    : %d%n", disponiveis.size());
        System.out.printf("  Quartos ocupados       : %d%n", todos.size() - disponiveis.size());
        System.out.printf("  Total de hospedes      : %d%n", hospedes.size());
        System.out.printf("  Reservas ativas        : %d%n", ativas.size());
        System.out.printf("  Devolucoes com atraso  : %d%n", atrasadas.size());
        System.out.println("============================================================\n");
    }

    public void gerarRelatorioQuartosOcupados() {
        List<Quarto> ocupados = quartoCtrl.listarOcupados();
        System.out.println("\n============================================================");
        System.out.println("               QUARTOS ATUALMENTE OCUPADOS                 ");
        System.out.println("============================================================");
        if (ocupados.isEmpty()) {
            System.out.println("  Nenhum quarto ocupado no momento.");
        } else {
            for (Quarto q : ocupados) System.out.println("  " + q);
        }
        System.out.println("============================================================\n");
    }

    public void gerarRelatorioHospedesAtrasados() {
        List<Reserva> atrasadas = reservaCtrl.listarAtrasadas();
        System.out.println("\n============================================================");
        System.out.println("       HOSPEDES COM CHECK-OUT EM ATRASO (desc.)            ");
        System.out.println("============================================================");
        if (atrasadas.isEmpty()) {
            System.out.println("  Nenhum hospede com atraso registrado.");
        } else {
            for (Reserva r : atrasadas) {
                System.out.printf("  Reserva #%d | %-20s | Quarto %d | Atraso: %d dia(s) | Check-out Prev.: %s | Efetivo: %s%n",
                        r.getId(), r.getHospede().getNome(), r.getQuarto().getNumero(),
                        r.getDiasAtraso(), r.getDataCheckOutPrevista(), r.getDataCheckOutEfetiva());
            }
        }
        System.out.println("============================================================\n");
    }

    public void gerarRelatorioQuartosMaisPopulares() {
        List<Quarto> populares = quartoCtrl.listarMaisPopulares();
        System.out.println("\n============================================================");
        System.out.println("         QUARTOS MAIS POPULARES (por n. de reservas)       ");
        System.out.println("============================================================");
        int rank = 1;
        for (Quarto q : populares) {
            System.out.printf("  %d. Quarto %d (%s) | Andar %d | R$ %.2f/noite | Reservado: %d vez(es)%n",
                    rank++, q.getNumero(), q.getTipoQuarto(), q.getAndar(),
                    q.getPrecoPorNoite(), q.getVezesReservado());
        }
        System.out.println("============================================================\n");
    }

    public void gerarRelatorioReservasAtivas() {
        List<Reserva> ativas = reservaCtrl.listarAtivas();
        System.out.println("\n============================================================");
        System.out.println("                   RESERVAS ATIVAS                         ");
        System.out.println("============================================================");
        if (ativas.isEmpty()) {
            System.out.println("  Nenhuma reserva ativa no momento.");
        } else {
            for (Reserva r : ativas) {
                System.out.println("  " + r);
                System.out.printf("    Valor previsto: R$ %.2f%n", r.getValorTotal());
            }
        }
        System.out.println("============================================================\n");
    }

    public void gerarRelatorioHistoricoCheckouts() {
        List<Reserva> concluidas = reservaCtrl.listarConcluidas();
        System.out.println("\n============================================================");
        System.out.println("               HISTORICO DE CHECK-OUTS                     ");
        System.out.println("============================================================");
        if (concluidas.isEmpty()) {
            System.out.println("  Nenhum check-out realizado ainda.");
        } else {
            double totalFaturado = 0;
            for (Reserva r : concluidas) {
                totalFaturado += r.getValorTotal();
                System.out.printf("  Reserva #%d | %s | Quarto %d | %d noite(s) | R$ %.2f | %s%n",
                        r.getId(), r.getHospede().getNome(), r.getQuarto().getNumero(),
                        r.getDiasHospedagem(), r.getValorTotal(),
                        r.temAtraso() ? "ATRASO: " + r.getDiasAtraso() + " dia(s)" : "No prazo");
            }
            System.out.printf("%n  TOTAL FATURADO: R$ %.2f%n", totalFaturado);
        }
        System.out.println("============================================================\n");
    }
}
