package controller;

import interfaces.Pesquisavel;
import model.Quarto;

import java.util.ArrayList;
import java.util.List;

public class QuartoController implements Pesquisavel<Quarto> {
    private List<Quarto> quartos = new ArrayList<>();

    public void adicionarQuarto(Quarto quarto) {
        for (Quarto q : quartos) {
            if (q.getNumero() == quarto.getNumero()) {
                throw new IllegalArgumentException("Ja existe um quarto com o numero " + quarto.getNumero() + ".");
            }
        }
        quartos.add(quarto);
    }

    @Override
    public Quarto buscarPorCodigo(int numero) {
        for (Quarto q : quartos) {
            if (q.getNumero() == numero) return q;
        }
        return null;
    }

    @Override
    public List<Quarto> buscarPorNome(String tipo) {
        List<Quarto> resultado = new ArrayList<>();
        for (Quarto q : quartos) {
            if (q.getTipoQuarto().equalsIgnoreCase(tipo)) resultado.add(q);
        }
        return resultado;
    }

    public List<Quarto> buscarPorAndar(int andar) {
        List<Quarto> resultado = new ArrayList<>();
        for (Quarto q : quartos) {
            if (q.getAndar() == andar) resultado.add(q);
        }
        return resultado;
    }

    public List<Quarto> listarDisponiveis() {
        List<Quarto> resultado = new ArrayList<>();
        for (Quarto q : quartos) {
            if (q.isDisponivel()) resultado.add(q);
        }
        return resultado;
    }

    public List<Quarto> listarOcupados() {
        List<Quarto> resultado = new ArrayList<>();
        for (Quarto q : quartos) {
            if (!q.isDisponivel()) resultado.add(q);
        }
        return resultado;
    }

    public List<Quarto> listarTodos() {
        return new ArrayList<>(quartos);
    }

    public List<Quarto> listarMaisPopulares() {
        List<Quarto> copia = new ArrayList<>(quartos);
        copia.sort((a, b) -> b.getVezesReservado() - a.getVezesReservado());
        return copia;
    }
}
