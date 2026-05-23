package model;

// Abstração: classe abstrata com comportamento genérico de item da biblioteca
public abstract class Item {
    protected int id;
    protected String title;

    public Item(int id, String title) {
        this.id = id;
        this.title = title;
    }

    public int getId()            { return id; }
    public String getTitle()      { return title; }
    public void setTitle(String t){ this.title = t; }

    // Polimorfismo: cada subclasse implementa sua própria versão
    public abstract String getInfo();

    @Override
    public String toString() { return getInfo(); }
}
