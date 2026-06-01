package view;

import controller.HospedeController;
import model.Hospede;

import java.util.InputMismatchException;
import java.util.List;
import java.util.Scanner;

public class HospedeView {
    private final HospedeController controller;
    private final Scanner sc;

    public HospedeView(HospedeController controller, Scanner sc) {
        this.controller = controller;
        this.sc = sc;
    }

    public void menuHospedes() {
        int opcao;
        do {
            System.out.println("\n╔══════════════════════════════╗");
            System.out.println("║      GESTAO DE HOSPEDES      ║");
            System.out.println("╠══════════════════════════════╣");
            System.out.println("║ 1 - Cadastrar hospede        ║");
            System.out.println("║ 2 - Listar todos             ║");
            System.out.println("║ 3 - Pesquisar hospede        ║");
            System.out.println("║ 0 - Voltar                   ║");
            System.out.println("╚══════════════════════════════╝");
            System.out.print("Opcao: ");
            opcao = lerInt();
            switch (opcao) {
                case 1 -> cadastrarHospede();
                case 2 -> listarTodos();
                case 3 -> menuPesquisa();
                case 0 -> System.out.println("Voltando...");
                default -> System.out.println("Opcao invalida.");
            }
        } while (opcao != 0);
    }

    private void cadastrarHospede() {
        System.out.println("\n--- CADASTRAR HOSPEDE ---");
        System.out.print("Nome completo : ");
        String nome = sc.nextLine().trim();
        System.out.print("Telefone      : ");
        String tel  = sc.nextLine().trim();
        System.out.print("E-mail        : ");
        String email= sc.nextLine().trim();
        System.out.print("Endereco      : ");
        String end  = sc.nextLine().trim();
        System.out.print("CPF           : ");
        String cpf  = sc.nextLine().trim();

        try {
            Hospede h = controller.cadastrarHospede(nome, tel, email, end, cpf);
            System.out.println("Hospede cadastrado com sucesso! ID: " + h.getId());
        } catch (Exception e) {
            System.out.println("ERRO: " + e.getMessage());
        }
    }

    private void listarTodos() {
        List<Hospede> lista = controller.listarTodos();
        System.out.println("\n--- HOSPEDES CADASTRADOS (" + lista.size() + ") ---");
        if (lista.isEmpty()) { System.out.println("Nenhum hospede cadastrado."); return; }
        for (Hospede h : lista) System.out.println("  " + h);
    }

    private void menuPesquisa() {
        System.out.println("\n--- PESQUISAR HOSPEDE ---");
        System.out.println("1 - Por ID   2 - Por nome   3 - Por CPF");
        System.out.print("Opcao: ");
        int op = lerInt();
        switch (op) {
            case 1 -> {
                System.out.print("ID do hospede: ");
                int id = lerInt();
                Hospede h = controller.buscarPorCodigo(id);
                if (h == null) System.out.println("Hospede nao encontrado.");
                else System.out.println("  " + h);
            }
            case 2 -> {
                System.out.print("Nome (ou parte): ");
                String nome = sc.nextLine().trim();
                List<Hospede> res = controller.buscarPorNome(nome);
                if (res.isEmpty()) System.out.println("Nenhum hospede encontrado.");
                else res.forEach(h -> System.out.println("  " + h));
            }
            case 3 -> {
                System.out.print("CPF: ");
                String cpf = sc.nextLine().trim();
                Hospede h = controller.buscarPorCpf(cpf);
                if (h == null) System.out.println("Hospede nao encontrado.");
                else System.out.println("  " + h);
            }
            default -> System.out.println("Opcao invalida.");
        }
    }

    private int lerInt() {
        while (true) {
            try { int v = sc.nextInt(); sc.nextLine(); return v; }
            catch (InputMismatchException e) { sc.nextLine(); System.out.print("Digite um numero inteiro: "); }
        }
    }
}
