package org.example.controller;

import org.example.models.Categoria;
import org.example.models.Producto;
import org.example.models.Usuario;

import java.util.ArrayList;
import java.util.List;
import java.util.Scanner;

public class MainController {
    private List<Categoria> categorias = new ArrayList<>();
    private Producto producto;
    private Usuario usuario;
    private Scanner scanner = new Scanner(System.in);

    public void añadirCategoria() {
        System.out.print("Ingrese el nombre de la nueva categoría: ");
        String nombre = scanner.nextLine();



        System.out.println("Categoría \"" + nombre + "\" añadida y guardada en tienda.json.");
    }

    public void obtenerCategorias() {
        if (categorias.isEmpty()) {
            System.out.println("⚠️ No hay categorías registradas.\n");
        } else {
            System.out.println("📋 Lista de categorías:");
            for (Categoria c : categorias) {
                System.out.println(c);
            }
        }
    }

    public void eliminarCategoria() {
        if (categorias.isEmpty()) {
            System.out.println("⚠️ No hay categorías registradas.\n");
        } else {
            System.out.print("Ingrese el ID de la categoría: ");
            int id = scanner.nextInt();
            scanner.nextLine(); // Consumir el salto de línea restante

            Categoria categoriaAEliminar = null;
            for (Categoria c : categorias) {
                if (c.getId() == id) {
                    categoriaAEliminar = c;
                    break;
                }
            }

            if (categoriaAEliminar != null) {
                categorias.remove(categoriaAEliminar);
                System.out.println("Categoría eliminada correctamente.\n");
            } else {
                System.out.println("❌ No se encontró una categoría con ID " + id + ".\n");
            }
        }
    }
}