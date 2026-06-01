package model;

public abstract class Pessoa {
    private int id;
    private String nome;
    private String telefone;
    private String email;
    private String endereco;

    public Pessoa(int id, String nome, String telefone, String email, String endereco) {
        this.id = id;
        this.nome = nome;
        this.telefone = telefone;
        this.email = email;
        this.endereco = endereco;
    }

    public int getId()               { return id; }
    public String getNome()          { return nome; }
    public void setNome(String n)    { this.nome = n; }
    public String getTelefone()      { return telefone; }
    public void setTelefone(String t){ this.telefone = t; }
    public String getEmail()         { return email; }
    public void setEmail(String e)   { this.email = e; }
    public String getEndereco()      { return endereco; }
    public void setEndereco(String e){ this.endereco = e; }

    public abstract String getTipo();

    @Override
    public String toString() {
        return String.format("[%d] %s | Tel: %s | Email: %s | End: %s",
                id, nome, telefone, email, endereco);
    }
}
