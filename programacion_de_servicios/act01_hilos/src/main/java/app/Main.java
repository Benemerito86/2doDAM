package app;

import controller.Contador;

public class Main {
    public static void main(String[] args) {

        Contador c1 = new Contador("Contador A", 5);
        Contador c2 = new Contador("Contador B", 3);
        Contador c3 = new Contador("Contador C", 4);
        Contador c4 = new Contador("Contador D", 2);

        Thread t1 = new Thread(c1);
        Thread t2 = new Thread(c2);
        Thread t3 = new Thread(c3);
        Thread t4 = new Thread(c4);

        try {

            System.out.println("--- Iniciando Hilo 1 ---");
            t1.start();
            t1.join();

            System.out.println("--- Iniciando Hilo 2 ---");
            t2.start();
            t2.join();

            System.out.println("--- Iniciando Hilo 3 ---");
            t3.start();
            t3.join();

            System.out.println("--- Iniciando Hilo 4 ---");
            t4.start();
            t4.join();

        } catch (InterruptedException e) {
            e.printStackTrace();
        }

        System.out.println("=== Todos los contadores han terminado ===");
    }
}
