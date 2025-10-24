import java.util.Scanner;

class Pila {
    private char[] elementos;
    private int tope;

    public Pila(int capacidad) {
        elementos = new char[capacidad];
        tope = -1;
    }

    public void push(char c) {
        if (tope + 1 >= elementos.length) {
            System.out.println("Pila llena");
            return;
        }
        tope++;
        elementos[tope] = c;
    }

    public char pop() {
        if (isEmpty()) {
            System.out.println("Pila vacía");
            return '\0';
        }
        char c = elementos[tope];
        tope--;
        return c;
    }

    public boolean isEmpty() {
        return tope == -1;
    }
}

public class Ejercicio01 {
    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);

        System.out.print("String a invertir: ");
        String texto = scanner.nextLine();

        Pila pila = new Pila(texto.length());

        for (int i = 0; i < texto.length(); i++) {
            pila.push(texto.charAt(i));
        }

        StringBuilder invertido = new StringBuilder();
        while (!pila.isEmpty()) {
            invertido.append(pila.pop());
        }

        System.out.println("Texto invertido: " + invertido.toString());
    }
}