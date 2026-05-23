package view;

import controller.UserController;
import model.User;

import java.util.List;

public class UserView {
    private final UserController ctrl;

    public UserView(UserController ctrl) { this.ctrl = ctrl; }

    public void menu() {
        boolean running = true;
        while (running) {
            ConsoleView.header("GERENCIAR USUÁRIOS");
            System.out.println("  1. Cadastrar Usuário");
            System.out.println("  2. Listar Todos os Usuários");
            System.out.println("  3. Buscar Usuário por Nome");
            System.out.println("  4. Remover Usuário");
            System.out.println("  0. Voltar");

            int opt = ConsoleView.readInt("\n  Opção: ");
            switch (opt) {
                case 1 -> cadastrar();
                case 2 -> listar();
                case 3 -> buscar();
                case 4 -> remover();
                case 0 -> running = false;
                default -> ConsoleView.err("Opção inválida.");
            }
            if (running && opt != 0) ConsoleView.pause();
        }
    }

    private void cadastrar() {
        ConsoleView.header("CADASTRAR USUÁRIO");
        try {
            String name    = ConsoleView.readString("  Nome:      ");
            String phone   = ConsoleView.readString("  Telefone:  ");
            String email   = ConsoleView.readString("  E-mail:    ");
            String address = ConsoleView.readString("  Endereço:  ");
            User u = ctrl.add(name, phone, email, address);
            ConsoleView.ok("Usuário cadastrado! ID: " + u.getId());
        } catch (IllegalArgumentException e) {
            ConsoleView.err(e.getMessage());
        }
    }

    private void listar() {
        ConsoleView.header("USUÁRIOS CADASTRADOS");
        List<User> users = ctrl.getAll();
        if (users.isEmpty()) { ConsoleView.info("Nenhum usuário cadastrado."); return; }
        users.forEach(u -> System.out.println("  " + u));
    }

    private void buscar() {
        ConsoleView.header("BUSCAR USUÁRIO");
        String name = ConsoleView.readString("  Nome: ");
        List<User> results = ctrl.searchByName(name);
        if (results.isEmpty()) ConsoleView.info("Nenhum usuário encontrado.");
        else results.forEach(u -> System.out.println("  " + u));
    }

    private void remover() {
        ConsoleView.header("REMOVER USUÁRIO");
        int id = ConsoleView.readInt("  ID do usuário: ");
        User u = ctrl.findById(id);
        if (u == null) { ConsoleView.err("Usuário não encontrado."); return; }
        System.out.println("\n  " + u);
        if (!ConsoleView.readString("\n  Confirmar remoção? (s/n): ").equalsIgnoreCase("s")) return;
        try {
            if (ctrl.remove(id)) ConsoleView.ok("Usuário removido com sucesso.");
            else ConsoleView.err("Não foi possível remover.");
        } catch (IllegalStateException e) {
            ConsoleView.err(e.getMessage());
        }
    }
}
