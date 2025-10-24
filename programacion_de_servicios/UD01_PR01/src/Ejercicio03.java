import java.util.LinkedList;
import java.util.Queue;
import java.util.Scanner;
import java.util.Stack;

public class Ejercicio03 {

    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);

        System.out.print("Introduce una palabra o frase: ");
        String texto = scanner.nextLine();

        texto = texto.toLowerCase().replaceAll("\\s+", "");

        Stack<Character> pila = new Stack<>();
        Queue<Character> cola = new LinkedList<>();

        for (char c : texto.toCharArray()) {
            pila.push(c);
            cola.add(c);
        }

        boolean esPalindromo = true;
        while (!pila.isEmpty() && !cola.isEmpty()) {
            char desdePila = pila.pop();
            char desdeCola = cola.remove();

            if (desdePila != desdeCola) {
                esPalindromo = false;
                break;
            }
        }

        if (esPalindromo) {
            System.out.println("Es palíndromo.");
        } else {
            System.out.println("No es palíndromo.");
        }

        scanner.close();
    }
}
