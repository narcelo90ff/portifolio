import controller.*;
import util.DataPreloader;
import view.*;

public class Main {
    public static void main(String[] args) {
        // ── Inicializa os controllers (Camada de Controle — MVC) ──────────────
        BookController   bookCtrl   = new BookController();
        UserController   userCtrl   = new UserController();
        LoanController   loanCtrl   = new LoanController();
        ReportController reportCtrl = new ReportController(bookCtrl, userCtrl, loanCtrl);

        // ── Pré-carga de dados de teste ───────────────────────────────────────
        DataPreloader.load(bookCtrl, userCtrl, loanCtrl);

        // ── Inicializa as views (Camada de Visão — MVC) ───────────────────────
        BookView   bookView   = new BookView(bookCtrl);
        UserView   userView   = new UserView(userCtrl);
        LoanView   loanView   = new LoanView(loanCtrl, bookCtrl, userCtrl);
        ReportView reportView = new ReportView(reportCtrl);
        MenuView   menuView   = new MenuView(bookView, userView, loanView, reportView);

        // ── Inicia o loop principal ───────────────────────────────────────────
        menuView.run();
    }
}
