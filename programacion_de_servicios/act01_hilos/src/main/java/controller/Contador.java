package controller;

public class Contador implements Runnable {
    private int limite;
    private String nombre;

    public Contador(String nombre, int limite) {
        this.nombre = nombre;
        this.limite = limite;
    }

    @Override
    public void run() {
        System.out.println("Iniciando: " + nombre + " (Hilo: " + Thread.currentThread().getName() + ")");

        for (int i = 1; i <= limite; i++) {
            System.out.println(nombre + ": " + i);
            try {
                Thread.sleep(500);
            } catch (InterruptedException e) {
                e.printStackTrace();
            }
        }
        System.out.println("Terminado: " + nombre);
    }
}