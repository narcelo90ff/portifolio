package model;

public class Hospede extends Pessoa {
    private String cpf;
    private boolean temReservaAtiva;

    public Hospede(int id, String nome, String telefone, String email, String endereco, String cpf) {
        super(id, nome, telefone, email, endereco);
        this.cpf = cpf;
        this.temReservaAtiva = false;
    }

    public String getCpf()                           { return cpf; }
    public boolean isTemReservaAtiva()               { return temReservaAtiva; }
    public void setTemReservaAtiva(boolean ativo)    { this.temReservaAtiva = ativo; }

    @Override
    public String getTipo() { return "Hospede"; }

    @Override
    public String toString() {
        return super.toString() + String.format(" | CPF: %s | Reserva Ativa: %s",
                cpf, temReservaAtiva ? "Sim" : "Nao");
    }
}
