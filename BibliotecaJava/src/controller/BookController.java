package controller;

import interfaces.Searchable;
import model.Book;

import java.util.*;
import java.util.stream.Collectors;

// Implementa a interface Searchable (polimorfismo via interface)
public class BookController implements Searchable {
    private final List<Book> books  = new ArrayList<>();
    private       int        nextId = 1;

    // ── CRUD ──────────────────────────────────────────────────────────────────

    public Book add(String title, String author, int year, String category, int copies) {
        if (title == null || title.isBlank())
            throw new IllegalArgumentException("Título não pode ser vazio.");
        if (copies <= 0)
            throw new IllegalArgumentException("Número de exemplares deve ser maior que zero.");

        Book book = new Book(nextId++, title.trim(), author.trim(), year, category.trim(), copies);
        books.add(book);
        return book;
    }

    public boolean remove(int id) {
        Book b = searchById(id);
        if (b == null) return false;
        if (b.getAvailableCopies() < b.getTotalCopies())
            throw new IllegalStateException("Livro possui exemplar(es) emprestado(s). Aguarde a devolução.");
        return books.removeIf(bk -> bk.getId() == id);
    }

    public List<Book> getAll() {
        return Collections.unmodifiableList(books);
    }

    // ── Searchable ────────────────────────────────────────────────────────────

    @Override
    public Book searchById(int id) {
        return books.stream().filter(b -> b.getId() == id).findFirst().orElse(null);
    }

    @Override
    public List<Book> searchByTitle(String title) {
        return books.stream()
                .filter(b -> b.getTitle().toLowerCase().contains(title.toLowerCase()))
                .collect(Collectors.toList());
    }

    @Override
    public List<Book> searchByAuthor(String author) {
        return books.stream()
                .filter(b -> b.getAuthor().toLowerCase().contains(author.toLowerCase()))
                .collect(Collectors.toList());
    }

    @Override
    public List<Book> searchByCategory(String category) {
        return books.stream()
                .filter(b -> b.getCategory().toLowerCase().contains(category.toLowerCase()))
                .collect(Collectors.toList());
    }

    // Expor nextId para o DataPreloader sincronizar se necessário
    public int  getNextId()          { return nextId; }
    public void setNextId(int nextId){ this.nextId = nextId; }
}
