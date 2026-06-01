package model;

public class QuartoSuite extends Quarto {
    private int numeroDeBanheiros;
    private boolean temSalaDeEstar;

    public QuartoSuite(int numero, int andar, int capacidade, double precoPorNoite,
                       int numeroDeBanheiros, boolean temSalaDeEstar) {
        super(numero, andar, capacidade, precoPorNoite);
        this.numeroDeBanheiros = numeroDeBanheiros;
        this.temSalaDeEstar = temSalaDeEstar;
    }

    public int getNumeroDeBanheiros()  { return numeroDeBanheiros; }
    public boolean isTemSalaDeEstar()  { return temSalaDeEstar; }

    @Override public String getTipoQuarto() { return "Suite"; }

    @Override
    public String getDescricaoComodidades() {
        return String.format("Suite completa com %d banheiro(s)%s, TV 65\", Cozinha equipada, Jacuzzi, Wi-Fi Premium",
                numeroDeBanheiros, temSalaDeEstar ? ", Sala de estar" : "");
    }
}
