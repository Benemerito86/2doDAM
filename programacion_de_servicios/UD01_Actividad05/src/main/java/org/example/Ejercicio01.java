package org.example;

import java.util.*;

public class Ejercicio01 {
    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);

        System.out.println("¿Qué quieres hacer? (apagar / reiniciar / suspender)");
        String accion = sc.nextLine().toLowerCase();

        System.out.println("¿Cuántos segundos deseas esperar?");
        int tiempo = sc.nextInt();

        String os = System.getProperty("os.name").toLowerCase();
        List<String> comando = new ArrayList<>();

        if (os.contains("win")) {
            // WINDOWS
            switch (accion) {
                case "apagar":
                    comando = Arrays.asList("shutdown", "/s", "/t", String.valueOf(tiempo));
                    break;
                case "reiniciar":
                    comando = Arrays.asList("shutdown", "/r", "/t", String.valueOf(tiempo));
                    break;
                case "suspender":
                    comando = Arrays.asList("rundll32.exe", "powrprof.dll,SetSuspendState", "Sleep");
                    break;
                default:
                    System.out.println("Acción no válida.");
                    return;
            }

        } else {
            // LINUX
            switch (accion) {
                case "apagar":
                    comando = Arrays.asList("shutdown", "-h", "+" + (tiempo / 60));
                    break;
                case "reiniciar":
                    comando = Arrays.asList("shutdown", "-r", "+" + (tiempo / 60));
                    break;
                case "suspender":
                    comando = Arrays.asList("systemctl", "suspend");
                    break;
                default:
                    System.out.println("Acción no válida.");
                    return;
            }
        }

        ProcessBuilder pb = new ProcessBuilder(comando);

        System.out.println("\nComando generado por ProcessBuilder:");
        System.out.println(pb.command());

        // No lo ejecuto para evitar apagar tu PC ;)
    }
}
