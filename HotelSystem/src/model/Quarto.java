package model;

public abstract class Quarto {
    private int numero;
    private int andar;
    private int capacidade;
    private double precoPorNoite;
    private boolean disponivel;
    private int vezesReservado;

    public Quarto(int numero, int andar, int capacidade, double precoPorNoite) {
        this.numero = numero;
        this.andar = andar;
        this.capacidade = capacidade;
        this.precoPorNoite = precoPorNoite;
        this.disponivel = true;
        this.vezesReservado = 0;
    }

    public int getNumero()                    { return numero; }
    public int getAndar()                     { return andar; }
    public int getCapacidade()                { return capacidade; }
    public double getPrecoPorNoite()          { return precoPorNoite; }
    public void setPrecoPorNoite(double p)    { this.precoPorNoite = p; }
    public boolean isDisponivel()             { return disponivel; }
    public void setDisponivel(boolean d)      { this.disponivel = d; }
    public int getVezesReservado()            { return vezesReservado; }
    public void incrementarReservas()         { this.vezesReservado++; }

    public abstract String getTipoQuarto();
    public abstract String getDescricaoComodidades();

    @Override
    public String toString() {
        return String.format("Quarto %d (%s) | Andar: %d | Capacidade: %d pax | R$ %.2f/noite | %s",
                numero, getTipoQuarto(), andar, capacidade, precoPorNoite,
                disponivel ? "DISPONIVEL" : "OCUPADO");
    }
}
