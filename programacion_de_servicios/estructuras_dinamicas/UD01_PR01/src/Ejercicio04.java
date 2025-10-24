import java.util.Scanner;

public class Ejercicio04 {
    public static String convertirEntero(int numero) {
        if (numero == 0) {
            return "";
        } else {
            int resto = numero % 2;
            return convertirEntero(numero / 2) + resto;
        }
    }
    public static String convertirFraccion(double fraccion) {
        StringBuilder binarioFrac = new StringBuilder();
        int limite = 10;
        while (fraccion > 0 && limite > 0) {
            fraccion *= 2;
            if (fraccion >= 1) {
                binarioFrac.append("1");
                fraccion -= 1;
            } else {
                binarioFrac.append("0");
            }
            limite--;
        }
        return binarioFrac.toString();
    }

    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);
        System.out.print("Ingrese un número decimal: ");
        double numero = scanner.nextDouble();

        int parteEntera = (int) numero;
        double parteFraccionaria = numero - parteEntera;

        String binEntero = convertirEntero(parteEntera);
        if (binEntero.isEmpty()) binEntero = "0";

        String binFraccion = convertirFraccion(parteFraccionaria);

        String resultado = binFraccion.isEmpty() ? binEntero : binEntero + "." + binFraccion;

        System.out.println("Binario: " + resultado);

        scanner.close();
    }
}
