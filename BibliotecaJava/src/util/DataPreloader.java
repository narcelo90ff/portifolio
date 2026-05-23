package util;

import controller.BookController;
import controller.LoanController;
import controller.UserController;
import model.Book;
import model.Loan;
import model.User;

import java.time.LocalDate;

/**
 * Classe responsável pela pré-carga de dados de teste no sistema.
 * Insere livros, usuários, empréstimos ativos e devoluções (incluindo com atraso).
 */
public class DataPreloader {

    public static void load(BookController bookCtrl, UserController userCtrl, LoanController loanCtrl) {

        // ── LIVROS ───────────────────────────────────────────────────────────
        bookCtrl.add("Dom Casmurro",                       "Machado de Assis",     1899, "Romance Brasileiro", 3);
        bookCtrl.add("Memórias Póstumas de Brás Cubas",    "Machado de Assis",     1881, "Romance Brasileiro", 2);
        bookCtrl.add("O Cortiço",                          "Aluísio Azevedo",      1890, "Naturalismo",        2);
        bookCtrl.add("Clean Code",                         "Robert C. Martin",     2008, "Tecnologia",         4);
        bookCtrl.add("Design Patterns",                    "Gang of Four",         1994, "Tecnologia",         2);
        bookCtrl.add("The Pragmatic Programmer",           "David Thomas",         1999, "Tecnologia",         3);
        bookCtrl.add("O Alquimista",                       "Paulo Coelho",         1988, "Ficção",             5);
        bookCtrl.add("1984",                               "George Orwell",        1949, "Distopia",           3);
        bookCtrl.add("Fundação",                           "Isaac Asimov",         1951, "Ficção Científica",  2);
        bookCtrl.add("O Senhor dos Anéis",                 "J.R.R. Tolkien",       1954, "Fantasia",           2);

        // ── USUÁRIOS ─────────────────────────────────────────────────────────
        userCtrl.add("Ana Lima",       "(41) 99999-1111", "ana@email.com",    "Rua das Flores, 10, Curitiba");
        userCtrl.add("Bruno Costa",    "(41) 98888-2222", "bruno@email.com",  "Av. Brasil, 200, Curitiba");
        userCtrl.add("Carla Souza",    "(41) 97777-3333", "carla@email.com",  "Rua XV de Novembro, 50");
        userCtrl.add("Diego Martins",  "(41) 96666-4444", "diego@email.com",  "Rua das Araucárias, 99");
        userCtrl.add("Elena Ferreira", "(41) 95555-5555", "elena@email.com",  "Alameda Santos, 300");
        userCtrl.add("Felipe Nunes",   "(41) 94444-6666", "felipe@email.com", "Bairro Alto, 77");

        // ── EMPRÉSTIMOS HISTÓRICOS (devolvidos) ──────────────────────────────
        // Ana pegou "O Alquimista" há 30 dias, devolveu com 5 dias de atraso
        {
            Book b = bookCtrl.searchById(7);   // O Alquimista
            User u = userCtrl.findById(1);     // Ana Lima
            b.lend();
            Loan l = new Loan(b, u, LocalDate.now().minusDays(30), 14);
            // expectedReturn = today-16, actual = today-11  →  atraso = 5 dias
            l.returnBook(LocalDate.now().minusDays(11));
            b.returnCopy();
            loanCtrl.registerHistoricalLoan(l);
        }
        // Bruno pegou "1984" há 25 dias, devolveu com 3 dias de atraso
        {
            Book b = bookCtrl.searchById(8);   // 1984
            User u = userCtrl.findById(2);     // Bruno Costa
            b.lend();
            Loan l = new Loan(b, u, LocalDate.now().minusDays(25), 14);
            // expectedReturn = today-11, actual = today-8  →  atraso = 3 dias
            l.returnBook(LocalDate.now().minusDays(8));
            b.returnCopy();
            loanCtrl.registerHistoricalLoan(l);
        }
        // Carla pegou "Fundação" há 20 dias, devolveu no prazo (dia 12)
        {
            Book b = bookCtrl.searchById(9);   // Fundação
            User u = userCtrl.findById(3);     // Carla Souza
            b.lend();
            Loan l = new Loan(b, u, LocalDate.now().minusDays(20), 14);
            l.returnBook(LocalDate.now().minusDays(8)); // no prazo
            b.returnCopy();
            loanCtrl.registerHistoricalLoan(l);
        }

        // ── EMPRÉSTIMOS ATIVOS (ainda em aberto) ─────────────────────────────
        // Diego com "Clean Code" — emprestado há 5 dias (no prazo)
        {
            Book b = bookCtrl.searchById(4);   // Clean Code
            User u = userCtrl.findById(4);     // Diego Martins
            b.lend();
            u.setHasActiveLoan(true);
            Loan l = new Loan(b, u, LocalDate.now().minusDays(5), 14);
            loanCtrl.registerActiveLoan(l);
        }
        // Elena com "Dom Casmurro" — emprestado há 20 dias (EM ATRASO há 6 dias)
        {
            Book b = bookCtrl.searchById(1);   // Dom Casmurro
            User u = userCtrl.findById(5);     // Elena Ferreira
            b.lend();
            u.setHasActiveLoan(true);
            Loan l = new Loan(b, u, LocalDate.now().minusDays(20), 14);
            loanCtrl.registerActiveLoan(l);
        }

        System.out.println("\n  ┌─────────────────────────────────────────┐");
        System.out.println("  │  PRÉ-CARGA CONCLUÍDA                    │");
        System.out.println("  │  · 10 livros cadastrados                │");
        System.out.println("  │  ·  6 usuários cadastrados              │");
        System.out.println("  │  ·  3 empréstimos históricos (fechados) │");
        System.out.println("  │  ·  2 empréstimos ativos                │");
        System.out.println("  │     (1 em dia, 1 em atraso)             │");
        System.out.println("  └─────────────────────────────────────────┘");
    }
}
