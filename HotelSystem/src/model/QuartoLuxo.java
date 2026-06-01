package model;

public class QuartoLuxo extends Quarto {
    private boolean temJacuzzi;

    public QuartoLuxo(int numero, int andar, int capacidade, double precoPorNoite, boolean temJacuzzi) {
        super(numero, andar, capacidade, precoPorNoite);
        this.temJacuzzi = temJacuzzi;
    }

    public boolean isTemJacuzzi() { return temJacuzzi; }

    @Override public String getTipoQuarto() { return "Luxo"; }

    @Override
    public String getDescricaoComodidades() {
        return "Cama king size, TV 55\", Frigobar, Ar-condicionado, Wi-Fi"
                + (temJacuzzi ? ", Jacuzzi" : "");
    }
}
