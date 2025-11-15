package org.example;

import java.io.File;
import java.io.IOException;

public class Ejercicio02 {
    public static void main(String[] args) throws IOException {
        String os = System.getProperty("os.name").toLowerCase();
        boolean windows = os.contains("win");

        // Crear comando inicial
        ProcessBuilder pb;

        if (windows) {
            pb = new ProcessBuilder("cmd.exe", "/c", "dir");
        } else {
            pb = new ProcessBuilder("ls", "-l");
        }

        // 1. Directorio inicial
        System.out.println("DIRECTORIO INICIAL (ProcessBuilder.directory()): " + pb.directory());

        // 2. Cambiar user.dir
        String nuevoDir = windows ? "C:\\temp" : "/tmp";
        System.setProperty("user.dir", nuevoDir);
        System.out.println("user.dir cambiado a: " + System.getProperty("user.dir"));

        // 3. Comprobar si existe la carpeta C:\temp o /tmp
        File tempDir = new File(nuevoDir);
        if (!tempDir.exists()) {
            System.out.println("El directorio no existe. Creándolo...");
            tempDir.mkdirs();
        }

        // Establecer nuevo directorio de trabajo
        pb.directory(tempDir);
        System.out.println("DIRECTORIO TRAS CAMBIAR pb.directory(): " + pb.directory());

        // 4. Ejecutar
        System.out.println("\n--- Resultado del comando ---\n");
        Process p = pb.start();
        p.getInputStream().transferTo(System.out);
    }
}


