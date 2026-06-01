package model;

public class QuartoSimples extends Quarto {
    public QuartoSimples(int numero, int andar, int capacidade, double precoPorNoite) {
        super(numero, andar, capacidade, precoPorNoite);
    }

    @Override public String getTipoQuarto()           { return "Simples"; }
    @Override public String getDescricaoComodidades() { return "Cama de solteiro, TV 32\", Ar-condicionado, Wi-Fi"; }
}
