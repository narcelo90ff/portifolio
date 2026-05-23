package view;

import java.util.Scanner;

public class ConsoleView {
    private static final Scanner sc = new Scanner(System.in);

    public static String readString(String prompt) {
        System.out.print(prompt);
        return sc.nextLine().trim();
    }

    public static int readInt(String prompt) {
        while (true) {
            System.out.print(prompt);
            try {
                return Integer.parseInt(sc.nextLine().trim());
            } catch (NumberFormatException e) {
                System.out.println("  ✗ Entrada inválida. Digite um número inteiro.");
            }
        }
    }

    public static void header(String title) {
        System.out.println("\n╔" + "═".repeat(54) + "╗");
        String padded = "  " + title;
        System.out.printf("║ %-53s║%n", padded);
        System.out.println("╚" + "═".repeat(54) + "╝");
    }

    public static void ok(String msg)    { System.out.println("  ✓ " + msg); }
    public static void err(String msg)   { System.out.println("  ✗ ERRO: " + msg); }
    public static void info(String msg)  { System.out.println("  ℹ " + msg); }

    public static void pause() {
        System.out.print("\n  Pressione ENTER para continuar...");
        sc.nextLine();
    }

    public static void close() { sc.close(); }
}
