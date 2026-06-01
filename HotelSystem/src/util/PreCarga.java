package util;

import controller.HospedeController;
import controller.QuartoController;
import controller.ReservaController;
import model.*;

import java.time.LocalDate;

public class PreCarga {

    public static void carregar(QuartoController qc, HospedeController hc, ReservaController rc) {
        System.out.println("  >> Carregando dados de pre-carga...");

        // ── Quartos ──────────────────────────────────────────────────────────
        qc.adicionarQuarto(new QuartoSimples(101, 1, 1, 150.00));
        qc.adicionarQuarto(new QuartoSimples(102, 1, 2, 180.00));
        qc.adicionarQuarto(new QuartoSimples(103, 1, 2, 180.00));
        qc.adicionarQuarto(new QuartoLuxo(201, 2, 2, 320.00, false));
        qc.adicionarQuarto(new QuartoLuxo(202, 2, 2, 350.00, true));
        qc.adicionarQuarto(new QuartoLuxo(203, 2, 3, 380.00, true));
        qc.adicionarQuarto(new QuartoSuite(301, 3, 4, 650.00, 2, true));
        qc.adicionarQuarto(new QuartoSuite(302, 3, 6, 900.00, 3, true));

        // ── Hospedes ─────────────────────────────────────────────────────────
        hc.cadastrarHospede("Ana Souza",      "21-99001-0001", "ana@email.com",    "Rua das Flores, 10",    "111.111.111-11");
        hc.cadastrarHospede("Bruno Lima",     "21-99001-0002", "bruno@email.com",  "Av. Central, 200",      "222.222.222-22");
        hc.cadastrarHospede("Carla Mendes",   "21-99001-0003", "carla@email.com",  "Estrada Nova, 55",      "333.333.333-33");
        hc.cadastrarHospede("Diego Rocha",    "21-99001-0004", "diego@email.com",  "Rua do Sol, 88",        "444.444.444-44");
        hc.cadastrarHospede("Eva Martins",    "21-99001-0005", "eva@email.com",    "Alameda das Acaias, 3", "555.555.555-55");
        hc.cadastrarHospede("Felipe Torres",  "21-99001-0006", "felipe@email.com", "Beco Azul, 12",         "666.666.666-66");
        hc.setProximoId(7);

        // ── Reservas + Check-outs concluidos ─────────────────────────────────
        Hospede ana    = hc.buscarPorCodigo(1);
        Hospede bruno  = hc.buscarPorCodigo(2);
        Hospede carla  = hc.buscarPorCodigo(3);
        Hospede diego  = hc.buscarPorCodigo(4);
        Hospede eva    = hc.buscarPorCodigo(5);
        Hospede felipe = hc.buscarPorCodigo(6);

        Quarto q101 = qc.buscarPorCodigo(101);
        Quarto q102 = qc.buscarPorCodigo(102);
        Quarto q201 = qc.buscarPorCodigo(201);
        Quarto q202 = qc.buscarPorCodigo(202);
        Quarto q203 = qc.buscarPorCodigo(203);
        Quarto q301 = qc.buscarPorCodigo(301);

        LocalDate hoje = LocalDate.now();

        // Reserva 1 – concluida sem atraso (Ana – Q101)
        Reserva r1 = rc.realizarReserva(ana, q101,
                hoje.minusDays(10), hoje.minusDays(5));
        rc.realizarCheckOut(r1.getId(), hoje.minusDays(5));   // pontual

        // Reserva 2 – concluida com 3 dias de atraso (Bruno – Q201)
        Reserva r2 = rc.realizarReserva(bruno, q201,
                hoje.minusDays(15), hoje.minusDays(8));
        rc.realizarCheckOut(r2.getId(), hoje.minusDays(5));   // 3 dias de atraso

        // Reserva 3 – concluida com 1 dia de atraso (Carla – Q202)
        Reserva r3 = rc.realizarReserva(carla, q202,
                hoje.minusDays(12), hoje.minusDays(7));
        rc.realizarCheckOut(r3.getId(), hoje.minusDays(6));   // 1 dia de atraso

        // Reserva 4 – ativa (Diego – Q102) -> disponivel=false
        rc.realizarReserva(diego, q102, hoje.minusDays(2), hoje.plusDays(3));

        // Reserva 5 – ativa (Eva – Q203)
        rc.realizarReserva(eva, q203, hoje, hoje.plusDays(5));

        // Reserva 6 – ativa (Felipe – Q301)
        rc.realizarReserva(felipe, q301, hoje.minusDays(1), hoje.plusDays(7));

        System.out.println("  >> Pre-carga concluida: 8 quartos, 6 hospedes, 6 reservas (3 ativas, 3 concluidas).\n");
    }
}
