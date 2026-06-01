package util;

import java.time.LocalDate;
import java.time.format.DateTimeFormatter;
import java.time.format.DateTimeParseException;
import java.util.Scanner;

/**
 * Utilitário de leitura e validação de entradas do console.
 */
public class InputUtil {
    private static final DateTimeFormatter FMT = DateTimeFormatter.ofPattern("dd/MM/yyyy");

    public static int lerInt(Scanner sc) {
        try {
            return Integer.parseInt(sc.nextLine().trim());
        } catch (NumberFormatException e) {
            return -1;
        }
    }

    public static double lerDouble(Scanner sc) {
        try {
            return Double.parseDouble(sc.nextLine().trim().replace(",", "."));
        } catch (NumberFormatException e) {
            return -1;
        }
    }

    public static String lerString(Scanner sc) {
        return sc.nextLine().trim();
    }

    public static LocalDate lerData(Scanner sc) {
        try {
            return LocalDate.parse(sc.nextLine().trim(), FMT);
        } catch (DateTimeParseException e) {
            return null;
        }
    }

    public static String fmt(LocalDate d) {
        return d != null ? d.format(FMT) : "---";
    }

    public static void linha() {
        System.out.println("  " + "─".repeat(60));
    }

    public static void titulo(String texto) {
        System.out.println();
        System.out.println("  ╔══════════════════════════════════════════════════════════╗");
        System.out.printf ("  ║  %-56s║%n", texto);
        System.out.println("  ╚══════════════════════════════════════════════════════════╝");
    }

    public static void subtitulo(String texto) {
        System.out.println();
        System.out.println("  ┌─ " + texto + " " + "─".repeat(Math.max(0, 55 - texto.length())) + "┐");
    }

    public static void fecharBox() {
        System.out.println("  └" + "─".repeat(59) + "┘");
    }
}