import java.util.LinkedList;
import java.util.Queue;
import java.util.Scanner;

class Cola {
    private Queue<String> colaClientes;

    public Cola() {
        colaClientes = new LinkedList<>();
    }

    public void llegada(String nombre) {
        colaClientes.add(nombre);
        System.out.println("Cliente " + nombre + " ha llegado.");
    }

    public void atender() {
        if (estaVacia()) {
            System.out.println("No hay clientes en la cola para atender.");
        } else {
            String atendido = colaClientes.poll(); // saca y devuelve el primero
            System.out.println("Cliente atendido: " + atendido);
        }
    }

    public void mostrar() {
        if (estaVacia()) {
            System.out.println("La cola está vacía.");
        } else {
            System.out.println("Clientes en espera:");
            for (String cliente : colaClientes) {
                System.out.println(" - " + cliente);
            }
        }
    }

    public boolean estaVacia() {
        return colaClientes.isEmpty();
    }
}

public class Ejercicio02 {
    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);
        Cola cola = new Cola();
        int opcion;

        do {
            System.out.println("\n=== MENÚ DE COLA DE CLIENTES ===");
            System.out.println("1. Llegada de cliente");
            System.out.println("2. Atender cliente");
            System.out.println("3. Mostrar cola");
            System.out.println("4. Salir");
            System.out.print("Seleccione una opción: ");
            opcion = scanner.nextInt();
            scanner.nextLine(); // limpiar salto de línea

            switch (opcion) {
                case 1:
                    System.out.print("Ingrese el nombre del cliente: ");
                    String nombre = scanner.nextLine();
                    cola.llegada(nombre);
                    break;

                case 2:
                    cola.atender();
                    break;

                case 3:
                    cola.mostrar();
                    break;

                case 4:
                    System.out.println("Saliendo del sistema...");
                    break;

                default:
                    System.out.println("Opción inválida. Intente de nuevo.");
            }

        } while (opcion != 4);

        scanner.close();
    }
}
