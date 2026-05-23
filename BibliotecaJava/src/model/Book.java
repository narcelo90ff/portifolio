package model;

// Herança: Book herda de Item
public class Book extends Item {
    private String author;
    private int year;
    private String category;
    private int totalCopies;
    private int availableCopies;
    private int loanCount; // para relatório de popularidade

    public Book(int id, String title, String author, int year, String category, int totalCopies) {
        super(id, title);
        if (totalCopies < 0) throw new IllegalArgumentException("Número de exemplares não pode ser negativo.");
        this.author         = author;
        this.year           = year;
        this.category       = category;
        this.totalCopies    = totalCopies;
        this.availableCopies = totalCopies;
        this.loanCount      = 0;
    }

    public String getAuthor()            { return author; }

    public void   setAuthor(String a)    { this.author = a; }
    public int    getYear()              { return year; }
    public void   setYear(int y)         { this.year = y; }
    public String getCategory()          { return category; }
    public void   setCategory(String c)  { this.category = c; }
    public int    getTotalCopies()       { return totalCopies; }
    public int    getAvailableCopies()   { return availableCopies; }
    public int    getLoanCount()         { return loanCount; }
    public boolean isAvailable()         { return availableCopies > 0; }

    public void lend() {
        if (availableCopies <= 0)
            throw new IllegalStateException("Nenhum exemplar disponível para o livro: " + title);
        availableCopies--;
        loanCount++;
    }

    public void returnCopy() {
        if (availableCopies >= totalCopies)
            throw new IllegalStateException("Todos os exemplares já estão disponíveis.");
        availableCopies++;
    }

    @Override
    public String getInfo() {
        return String.format("[ID:%d] %-40s | Autor: %-25s | Ano: %d | Categoria: %-18s | Disponíveis: %d/%d",
                id, title, author, year, category, availableCopies, totalCopies);
    }
}
