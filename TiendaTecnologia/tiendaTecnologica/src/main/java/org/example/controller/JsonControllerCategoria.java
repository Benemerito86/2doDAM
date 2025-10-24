package org.example.controller;

import org.json.JSONObject;
import org.json.JSONArray;


import java.io.FileWriter;
import java.io.IOException;
import java.nio.charset.StandardCharsets;
import java.nio.file.Files;
import java.nio.file.Paths;
import java.util.Scanner;

import static java.awt.AWTEventMulticaster.remove;

public class JsonControllerCategoria {

    public static void leerCategorias() {

        try {
            JSONObject json = leerJsonDesdeArchivo("src/main/java/org/example/tienda.json");
            JSONObject tienda = json.getJSONObject("tienda");
            String nombreTienda = tienda.getString("nombre");
            JSONArray categorias = tienda.getJSONArray("categorias");
            System.out.println("Nombre tienda: " + nombreTienda);
            for (int i = 0; i < categorias.length(); i++) {
                JSONObject categoria = categorias.getJSONObject(i);
                int id = categoria.getInt("id"); // 🔹 usar getInt en vez de getString
                String nombre = categoria.getString("nombre");
                System.out.println(id + ". " + nombre);
            }



        } catch (IOException e) {
            e.printStackTrace();
        } catch (Exception e) {
            throw new RuntimeException(e);
        }
    }
    public void eliminarCategoria() {
        try {
            Scanner scanner = new Scanner(System.in);
            String ruta = "src/main/java/org/example/tienda.json";
            String contenido = Files.readString(Paths.get(ruta), StandardCharsets.UTF_8);
            JSONObject json = new JSONObject(contenido);
            JSONObject tienda = json.getJSONObject("tienda");
            String nombreTienda = tienda.getString("nombre");
            JSONArray categorias = tienda.getJSONArray("categorias");
            System.out.println("Nombre tienda: " + nombreTienda);

            if (categorias.length() == 0) {
                System.out.println("No tiene categorias");
            }else{
                leerCategorias();
            }
            int idABorrar = scanner.nextInt();
            for (int i = 0; i < categorias.length(); i++) {
                JSONObject categoria = categorias.getJSONObject(i);
                if (categoria.getInt("id") == idABorrar) {
                    categorias.remove(i);
                    System.out.println("Categoria eliminada");
                    break;
                }
            }

            guardarJsonArchivo(json, ruta);

            System.out.println("Categoría eliminada.");


        } catch (IOException e) {
            e.printStackTrace();
        } catch (Exception e) {
            throw new RuntimeException(e);
        }
    }
    public void añadirCategoria() {
        try {
            Scanner scanner = new Scanner(System.in);
            String ruta = "src/main/java/org/example/tienda.json";
            JSONObject json = leerJsonDesdeArchivo(ruta);
            JSONObject tienda = json.getJSONObject("tienda");
            JSONArray categorias = tienda.getJSONArray("categorias");

            System.out.print("Nombre de la categoria: ");
            String nombre = scanner.nextLine();

            // 🔹 Calcular ID único
            int maxId = 0;
            for (int i = 0; i < categorias.length(); i++) {
                int idActual = categorias.getJSONObject(i).getInt("id");
                if (idActual > maxId) {
                    maxId = idActual;
                }
            }
            int nuevoId = maxId + 1;

            // 🔹 Crear nueva categoría
            JSONObject nuevaCategoria = new JSONObject();
            nuevaCategoria.put("id", nuevoId);
            nuevaCategoria.put("nombre", nombre);

            categorias.put(nuevaCategoria);

            guardarJsonArchivo(json, ruta);
            System.out.println("Categoría añadida");
            leerCategorias();

        } catch (IOException e) {
            e.printStackTrace();
        } catch (Exception e) {
            throw new RuntimeException(e);
        }
    }


    public static JSONObject leerJsonDesdeArchivo(String ruta) throws Exception {
        String contenido = Files.readString(Paths.get(ruta), StandardCharsets.UTF_8);
        return new JSONObject(contenido);
    }

    // Guardar JSON en archivo
    public static void guardarJsonArchivo(JSONObject json, String ruta) throws Exception {
        try (FileWriter file = new FileWriter(ruta)) {
            file.write(json.toString(4)); // Formateado con indentación
        }
    }



}
