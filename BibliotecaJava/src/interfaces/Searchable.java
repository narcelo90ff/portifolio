package interfaces;

import model.Book;
import java.util.List;

public interface Searchable {
    Book searchById(int id);
    List<Book> searchByTitle(String title);
    List<Book> searchByAuthor(String author);
    List<Book> searchByCategory(String category);
}
