package model;

import java.time.LocalDate;
import java.time.temporal.ChronoUnit;

public class Reserva {
    private static int contadorId = 1;

    private int id;
    private Hospede hospede;
    private Quarto quarto;
    private LocalDate dataCheckIn;
    private LocalDate dataCheckOutPrevista;
    private LocalDate dataCheckOutEfetiva;
    private StatusReserva status;
    private long diasAtraso;

    public Reserva(Hospede hospede, Quarto quarto, LocalDate dataCheckIn, LocalDate dataCheckOutPrevista) {
        this.id = contadorId++;
        this.hospede = hospede;
        this.quarto = quarto;
        this.dataCheckIn = dataCheckIn;
        this.dataCheckOutPrevista = dataCheckOutPrevista;
        this.status = StatusReserva.ATIVA;
        this.diasAtraso = 0;
    }

    // Used by PreCarga to set specific IDs
    public static void resetContador(int valor) { contadorId = valor; }

    public int getId()                          { return id; }
    public Hospede getHospede()                 { return hospede; }
    public Quarto getQuarto()                   { return quarto; }
    public LocalDate getDataCheckIn()           { return dataCheckIn; }
    public LocalDate getDataCheckOutPrevista()  { return dataCheckOutPrevista; }
    public LocalDate getDataCheckOutEfetiva()   { return dataCheckOutEfetiva; }
    public StatusReserva getStatus()            { return status; }
    public long getDiasAtraso()                 { return diasAtraso; }

    public void realizarCheckOut(LocalDate dataEfetiva) {
        this.dataCheckOutEfetiva = dataEfetiva;
        this.status = StatusReserva.CONCLUIDA;
        long atraso = ChronoUnit.DAYS.between(dataCheckOutPrevista, dataEfetiva);
        this.diasAtraso = atraso > 0 ? atraso : 0;
    }

    public long getDiasHospedagem() {
        LocalDate fim = (dataCheckOutEfetiva != null) ? dataCheckOutEfetiva : dataCheckOutPrevista;
        return ChronoUnit.DAYS.between(dataCheckIn, fim);
    }

    public double getValorTotal() {
        return getDiasHospedagem() * quarto.getPrecoPorNoite();
    }

    public boolean temAtraso() { return diasAtraso > 0; }

    @Override
    public String toString() {
        return String.format("[Reserva #%d] Hospede: %-20s | Quarto: %d (%-7s) | Check-in: %s | Check-out Prev.: %s | Status: %s",
                id, hospede.getNome(), quarto.getNumero(), quarto.getTipoQuarto(),
                dataCheckIn, dataCheckOutPrevista, status);
    }
}
