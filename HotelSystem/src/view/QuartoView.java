package view;

import controller.QuartoController;
import model.*;

import java.util.InputMismatchException;
import java.util.List;
import java.util.Scanner;

public class QuartoView {
    private final QuartoController controller;
    private final Scanner sc;

    public QuartoView(QuartoController controller, Scanner sc) {
        this.controller = controller;
        this.sc = sc;
    }

    public void menuQuartos() {
        int opcao;
        do {
            System.out.println("\n╔══════════════════════════════╗");
            System.out.println("║       GESTAO DE QUARTOS      ║");
            System.out.println("╠══════════════════════════════╣");
            System.out.println("║ 1 - Cadastrar quarto         ║");
            System.out.println("║ 2 - Listar todos os quartos  ║");
            System.out.println("║ 3 - Listar disponiveis       ║");
            System.out.println("║ 4 - Pesquisar quarto         ║");
            System.out.println("║ 0 - Voltar                   ║");
            System.out.println("╚══════════════════════════════╝");
            System.out.print("Opcao: ");
            opcao = lerInt();
            switch (opcao) {
                case 1 -> cadastrarQuarto();
                case 2 -> listarTodos();
                case 3 -> listarDisponiveis();
                case 4 -> menuPesquisa();
                case 0 -> System.out.println("Voltando...");
                default -> System.out.println("Opcao invalida.");
            }
        } while (opcao != 0);
    }

    private void cadastrarQuarto() {
        System.out.println("\n--- CADASTRAR QUARTO ---");
        System.out.print("Numero do quarto: ");
        int numero = lerInt();
        System.out.print("Andar: ");
        int andar = lerInt();
        System.out.print("Capacidade (pessoas): ");
        int cap = lerInt();
        System.out.print("Preco por noite (R$): ");
        double preco = lerDouble();
        System.out.println("Tipo: 1-Simples  2-Luxo  3-Suite");
        System.out.print("Escolha: ");
        int tipo = lerInt();

        try {
            Quarto q;
            switch (tipo) {
                case 1 -> q = new QuartoSimples(numero, andar, cap, preco);
                case 2 -> {
                    System.out.print("Tem jacuzzi? (s/n): ");
                    boolean jac = sc.next().equalsIgnoreCase("s");
                    sc.nextLine();
                    q = new QuartoLuxo(numero, andar, cap, preco, jac);
                }
                case 3 -> {
                    System.out.print("Numero de banheiros: ");
                    int ban = lerInt();
                    System.out.print("Tem sala de estar? (s/n): ");
                    boolean sala = sc.next().equalsIgnoreCase("s");
                    sc.nextLine();
                    q = new QuartoSuite(numero, andar, cap, preco, ban, sala);
                }
                default -> { System.out.println("Tipo invalido."); return; }
            }
            controller.adicionarQuarto(q);
            System.out.println("Quarto " + numero + " (" + q.getTipoQuarto() + ") cadastrado com sucesso!");
            System.out.println("Comodidades: " + q.getDescricaoComodidades());
        } catch (Exception e) {
            System.out.println("ERRO: " + e.getMessage());
        }
    }

    private void listarTodos() {
        List<Quarto> lista = controller.listarTodos();
        System.out.println("\n--- TODOS OS QUARTOS (" + lista.size() + ") ---");
        if (lista.isEmpty()) { System.out.println("Nenhum quarto cadastrado."); return; }
        for (Quarto q : lista) System.out.println("  " + q);
    }

    private void listarDisponiveis() {
        List<Quarto> lista = controller.listarDisponiveis();
        System.out.println("\n--- QUARTOS DISPONIVEIS (" + lista.size() + ") ---");
        if (lista.isEmpty()) { System.out.println("Nenhum quarto disponivel."); return; }
        for (Quarto q : lista) System.out.println("  " + q);
    }

    private void menuPesquisa() {
        System.out.println("\n--- PESQUISAR QUARTO ---");
        System.out.println("1 - Por numero   2 - Por tipo   3 - Por andar");
        System.out.print("Opcao: ");
        int op = lerInt();
        switch (op) {
            case 1 -> {
                System.out.print("Numero do quarto: ");
                int n = lerInt();
                Quarto q = controller.buscarPorCodigo(n);
                if (q == null) System.out.println("Quarto nao encontrado.");
                else { System.out.println("  " + q); System.out.println("  Comodidades: " + q.getDescricaoComodidades()); }
            }
            case 2 -> {
                System.out.print("Tipo (Simples/Luxo/Suite): ");
                String t = sc.nextLine().trim();
                List<Quarto> res = controller.buscarPorNome(t);
                if (res.isEmpty()) System.out.println("Nenhum quarto do tipo \"" + t + "\" encontrado.");
                else res.forEach(q -> System.out.println("  " + q));
            }
            case 3 -> {
                System.out.print("Andar: ");
                int a = lerInt();
                List<Quarto> res = controller.buscarPorAndar(a);
                if (res.isEmpty()) System.out.println("Nenhum quarto no andar " + a + ".");
                else res.forEach(q -> System.out.println("  " + q));
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

    private double lerDouble() {
        while (true) {
            try { double v = sc.nextDouble(); sc.nextLine(); return v; }
            catch (InputMismatchException e) { sc.nextLine(); System.out.print("Digite um valor numerico: "); }
        }
    }
}
