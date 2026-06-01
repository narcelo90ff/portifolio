package controller;

import model.Hospede;
import model.Quarto;
import model.Reserva;
import model.StatusReserva;

import java.time.LocalDate;
import java.util.ArrayList;
import java.util.List;

public class ReservaController {
    private List<Reserva> reservas  = new ArrayList<>();
    private List<Reserva> atrasadas = new ArrayList<>();

    public Reserva realizarReserva(Hospede hospede, Quarto quarto,
                                   LocalDate checkIn, LocalDate checkOutPrevisto) {
        if (hospede.isTemReservaAtiva()) {
            throw new IllegalStateException(
                    "O hospede \"" + hospede.getNome() + "\" ja possui uma reserva ativa.");
        }
        if (!quarto.isDisponivel()) {
            throw new IllegalStateException(
                    "O quarto " + quarto.getNumero() + " nao esta disponivel.");
        }
        if (!checkIn.isBefore(checkOutPrevisto)) {
            throw new IllegalArgumentException(
                    "A data de check-in deve ser anterior a data de check-out.");
        }

        Reserva reserva = new Reserva(hospede, quarto, checkIn, checkOutPrevisto);
        hospede.setTemReservaAtiva(true);
        quarto.setDisponivel(false);
        quarto.incrementarReservas();
        reservas.add(reserva);
        return reserva;
    }

    public Reserva realizarCheckOut(int reservaId, LocalDate dataEfetiva) {
        Reserva reserva = buscarPorId(reservaId);
        if (reserva == null) {
            throw new IllegalArgumentException("Reserva #" + reservaId + " nao encontrada.");
        }
        if (reserva.getStatus() != StatusReserva.ATIVA) {
            throw new IllegalStateException("A reserva #" + reservaId + " nao esta ativa.");
        }
        if (dataEfetiva.isBefore(reserva.getDataCheckIn())) {
            throw new IllegalArgumentException("Data de check-out nao pode ser anterior ao check-in.");
        }

        reserva.realizarCheckOut(dataEfetiva);
        reserva.getHospede().setTemReservaAtiva(false);
        reserva.getQuarto().setDisponivel(true);

        if (reserva.temAtraso()) {
            atrasadas.add(reserva);
            atrasadas.sort((a, b) -> Long.compare(b.getDiasAtraso(), a.getDiasAtraso()));
        }
        return reserva;
    }

    public Reserva buscarPorId(int id) {
        for (Reserva r : reservas) {
            if (r.getId() == id) return r;
        }
        return null;
    }

    public Reserva buscarReservaAtivaDoHospede(int hospedeId) {
        for (Reserva r : reservas) {
            if (r.getHospede().getId() == hospedeId && r.getStatus() == StatusReserva.ATIVA) {
                return r;
            }
        }
        return null;
    }

    public List<Reserva> listarAtivas() {
        List<Reserva> resultado = new ArrayList<>();
        for (Reserva r : reservas) {
            if (r.getStatus() == StatusReserva.ATIVA) resultado.add(r);
        }
        return resultado;
    }

    public List<Reserva> listarConcluidas() {
        List<Reserva> resultado = new ArrayList<>();
        for (Reserva r : reservas) {
            if (r.getStatus() == StatusReserva.CONCLUIDA) resultado.add(r);
        }
        return resultado;
    }

    public List<Reserva> listarTodas()    { return new ArrayList<>(reservas); }
    public List<Reserva> listarAtrasadas(){ return new ArrayList<>(atrasadas); }
}
