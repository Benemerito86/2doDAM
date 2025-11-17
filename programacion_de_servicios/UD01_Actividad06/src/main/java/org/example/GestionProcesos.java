package org.example;

import java.io.IOException;

public class GestionProcesos {

    public static void main(String[] args) {

        String[] comandos = {
                "notepad",          // existe
                "calc",             // existe
                "cmd /c dir",       // existe, comando interno
                "cmd /c tree",      // existe
                "programaInexistente.exe",  // no existe
                "cmd /c dir /x /parametroIncorrecto"  // parámetros incorrectos
        };

        for (String comando : comandos) {
            try {
                System.out.println("\nEjecutando: " + comando);

                // Ejecutamos el comando
                Process proceso = Runtime.getRuntime().exec(comando);

                // Esperamos a que termine
                int exitCode = proceso.waitFor();

                System.out.println("Finalizado: " + comando);
                System.out.println("Código de salida: " + exitCode);

            } catch (IOException e) {
                System.out.println("ERROR ejecutando: " + comando);
                System.out.println("Motivo: " + e.getMessage());
            } catch (InterruptedException e) {
                System.out.println("Proceso interrumpido.");
            }
        }

        System.out.println("\nPrograma principal finalizado.");
    }
}
