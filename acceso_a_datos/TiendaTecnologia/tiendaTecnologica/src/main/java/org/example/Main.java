package org.example;

import org.example.controller.*;

import java.util.Scanner;

public class Main {
    public static void main(String[] args) {
        MainController controller = new MainController();
        JsonControllerCategoria jsonControllerCategoria = new JsonControllerCategoria();
        Scanner sc = new Scanner(System.in);
        boolean salir = false;

        System.out.println("🖥️ Bienvenido al sistema de gestión de la tienda informática");

        do {
            System.out.println("\nMenú principal:" +
                    "\n1. Categorías" +
                    "\n2. Productos" +
                    "\n3. Usuarios" +
                    "\n4. Compras" +
                    "\n5. Salir");
            System.out.print("Elige una opción: ");
            int opcion = sc.nextInt();

            switch (opcion) {
                case 1:
                    boolean salirCat = false;
                    do {
                        System.out.println("\nSubmenú de categorías:" +
                                "\n1. Añadir categoría" +
                                "\n2. Mostrar categorías" +
                                "\n3. Eliminar categorías" +
                                "\n4. Volver al menú principal");
                        System.out.print("Elige una opción: ");
                        int sub = sc.nextInt();

                        switch (sub) {
                            case 1 -> jsonControllerCategoria.añadirCategoria();
                            case 2 -> jsonControllerCategoria.leerCategorias();
                            case 3 -> jsonControllerCategoria.eliminarCategoria();
                            case 4 -> salirCat = true;
                            default -> System.out.println("Opción no válida.");
                        }
                    } while (!salirCat);
                    break;

                case 2:
                    boolean salirProductos = false;
                    do {
                        System.out.println("\nSubmenú de productos:" +
                                "\n1. Añadir producto" +
                                "\n2. Mostrar productos" +
                                "\n3. Eliminar productos" +
                                "\n4. Volver al menú principal");
                        System.out.print("Elige una opción: ");
                        int sub = sc.nextInt();

                        switch (sub) {
                            case 1 -> JsonControllerProducto.añadirProducto();
                            case 2 -> JsonControllerProducto.leerProductos();
                            case 3 -> JsonControllerProducto.eliminarProducto();
                            case 4 -> salirProductos = true;
                            default -> System.out.println("Opción no válida.");
                        }
                    } while (!salirProductos);
                    break;

                case 3:
                    boolean salirUser = false;
                    do {
                        System.out.println("\nSubmenú de usuarios:" +
                                "\n1. Añadir usuario" +
                                "\n2. Mostrar usuarios" +
                                "\n3. Eliminar usuario" +
                                "\n4. Volver al menú principal");
                        System.out.print("Elige una opción: ");
                        int sub = sc.nextInt();

                        switch (sub) {
                            case 1 -> JsonControllerUsuario.añadirUsuario();
                            case 2 -> JsonControllerUsuario.verUsuarios();
                            case 3 -> JsonControllerUsuario.eliminarUsuario();
                            case 4 -> salirUser = true;
                            default -> System.out.println("Opción no válida.");
                        }
                    } while (!salirUser);
                    break;

                case 4:
                    boolean salirCompra = false;
                    do {
                        System.out.println("\nSubmenú de compras:" +
                                "\n1. Añadir compra" +
                                "\n2. Mostrar compras" +
                                "\n3. Eliminar compra" +
                                "\n4. Volver al menú principal");
                        System.out.print("Elige una opción: ");
                        int sub = sc.nextInt();

                        switch (sub) {
                            case 1 -> JsonControllerCompra.añadirCompra();
                            case 2 -> JsonControllerUsuario.verUsuarios();
                            case 3 -> JsonControllerCompra.eliminarCompra();
                            case 4 -> salirCompra = true;
                            default -> System.out.println("Opción no válida.");
                        }
                    } while (!salirCompra);
                    break;


                case 5:
                    System.out.println("👋 Saliendo del programa...");
                    salir = true;
                    break;

                default:
                    System.out.println("Opción no válida.");
            }
        } while (!salir);
    }
}