package controller;

import interfaces.Pesquisavel;
import model.Hospede;

import java.util.ArrayList;
import java.util.List;

public class HospedeController implements Pesquisavel<Hospede> {
    private List<Hospede> hospedes = new ArrayList<>();
    private int proximoId = 1;

    public Hospede cadastrarHospede(String nome, String telefone, String email, String endereco, String cpf) {
        for (Hospede h : hospedes) {
            if (h.getCpf().equals(cpf)) {
                throw new IllegalArgumentException("Ja existe um hospede cadastrado com o CPF " + cpf + ".");
            }
        }
        Hospede hospede = new Hospede(proximoId++, nome, telefone, email, endereco, cpf);
        hospedes.add(hospede);
        return hospede;
    }

    @Override
    public Hospede buscarPorCodigo(int id) {
        for (Hospede h : hospedes) {
            if (h.getId() == id) return h;
        }
        return null;
    }

    @Override
    public List<Hospede> buscarPorNome(String nome) {
        List<Hospede> resultado = new ArrayList<>();
        for (Hospede h : hospedes) {
            if (h.getNome().toLowerCase().contains(nome.toLowerCase())) resultado.add(h);
        }
        return resultado;
    }

    public Hospede buscarPorCpf(String cpf) {
        for (Hospede h : hospedes) {
            if (h.getCpf().equals(cpf)) return h;
        }
        return null;
    }

    public List<Hospede> listarTodos() {
        return new ArrayList<>(hospedes);
    }

    public void setProximoId(int id) { this.proximoId = id; }
}
