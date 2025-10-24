package org.example.controller;

import org.json.JSONArray;
import org.json.JSONObject;

import java.io.FileWriter;
import java.io.IOException;
import java.nio.charset.StandardCharsets;
import java.nio.file.Files;
import java.nio.file.Paths;
import java.util.Scanner;

public class JsonControllerProducto {

    public static void leerProductos() {

        try {
            JSONObject json = leerJsonDesdeArchivo("src/main/java/org/example/tienda.json");
            JSONObject tienda = json.getJSONObject("tienda");
            JSONArray categorias = tienda.getJSONArray("categorias");

            for (int i = 0; i < categorias.length(); i++) {
                JSONObject categoria = categorias.getJSONObject(i);
                String nombreCategoria = categoria.getString("nombre");
                System.out.println("Categoría: " + nombreCategoria);

                // 🔹 Comprobar si tiene productos
                if (categoria.has("productos")) {
                    JSONArray productos = categoria.getJSONArray("productos");
                    if (productos.length() == 0) {
                        System.out.println("  No hay productos en esta categoría.");
                    } else {
                        for (int j = 0; j < productos.length(); j++) {
                            JSONObject producto = productos.getJSONObject(j);
                            int id = producto.getInt("id");
                            String nombre = producto.getString("nombre");
                            double precio = producto.getDouble("precio");
                            System.out.println("  " + id + ". " + nombre + " - $" + precio);
                        }
                    }
                } else {
                    System.out.println("  Esta categoría no tiene productos.");
                }

                System.out.println(); // línea en blanco entre categorías
            }

        } catch (Exception e) {
            e.printStackTrace();
        }

    }
    public static void añadirProducto(){
        try {
            Scanner scanner = new Scanner(System.in);
            String ruta = "src/main/java/org/example/tienda.json";
            JSONObject json = leerJsonDesdeArchivo(ruta);
            JSONObject tienda = json.getJSONObject("tienda");
            JSONArray categorias = tienda.getJSONArray("categorias");

            // Mostrar categorías para elegir
            System.out.println("Categorías disponibles:");
            for (int i = 0; i < categorias.length(); i++) {
                JSONObject cat = categorias.getJSONObject(i);
                System.out.println(cat.getInt("id") + ". " + cat.getString("nombre"));
            }

            System.out.print("Ingrese el ID de la categoría donde añadir el producto: ");
            int idCategoria = scanner.nextInt();
            scanner.nextLine(); // limpiar salto de línea

            // Buscar categoría
            JSONObject categoriaSeleccionada = null;
            for (int i = 0; i < categorias.length(); i++) {
                JSONObject cat = categorias.getJSONObject(i);
                if (cat.getInt("id") == idCategoria) {
                    categoriaSeleccionada = cat;
                    break;
                }
            }

            if (categoriaSeleccionada == null) {
                System.out.println("Categoría no encontrada.");
                return;
            }

            // Pedir datos del producto
            System.out.print("Nombre del producto: ");
            String nombre = scanner.nextLine();
            System.out.print("Precio: ");
            double precio = scanner.nextDouble();
            scanner.nextLine(); // limpiar
            System.out.print("Descripción: ");
            String descripcion = scanner.nextLine();
            System.out.print("Pantalla: ");
            String pantalla = scanner.nextLine();
            System.out.print("Cámara: ");
            String camara = scanner.nextLine();
            System.out.print("Batería: ");
            String bateria = scanner.nextLine();
            System.out.print("Inventario: ");
            int inventario = scanner.nextInt();

            // Crear array de productos si no existe
            JSONArray productos;
            if (categoriaSeleccionada.has("productos")) {
                productos = categoriaSeleccionada.getJSONArray("productos");
            } else {
                productos = new JSONArray();
                    categoriaSeleccionada.put("productos", productos);
                }

                // Generar ID único para el producto
                int maxId = 0;
                for (int i = 0; i < categorias.length(); i++) {
                    JSONArray prods = categorias.getJSONObject(i).optJSONArray("productos");
                    if (prods != null) {
                        for (int j = 0; j < prods.length(); j++) {
                            int idProd = prods.getJSONObject(j).getInt("id");
                            if (idProd > maxId) maxId = idProd;
                        }
                    }
                }
                int nuevoId = maxId + 1;

                // Crear producto
                JSONObject nuevoProducto = new JSONObject();
                nuevoProducto.put("id", nuevoId);
                nuevoProducto.put("nombre", nombre);
                nuevoProducto.put("precio", precio);
                nuevoProducto.put("descripcion", descripcion);

                JSONObject caracteristicas = new JSONObject();
                caracteristicas.put("pantalla", pantalla);
                caracteristicas.put("camara", camara);
                caracteristicas.put("bateria", bateria);

                nuevoProducto.put("caracteristicas", caracteristicas);
                nuevoProducto.put("inventario", inventario);

                // Añadir producto a la categoría
                productos.put(nuevoProducto);

                // Guardar cambios
                guardarJsonArchivo(json, ruta);

                System.out.println("Producto añadido");

            } catch (Exception e) {
                e.printStackTrace();
            }
        }
    public static void eliminarProducto() {
        try {
            Scanner scanner = new Scanner(System.in);
            String ruta = "src/main/java/org/example/tienda.json";
            JSONObject json = leerJsonDesdeArchivo(ruta);
            JSONObject tienda = json.getJSONObject("tienda");
            JSONArray categorias = tienda.getJSONArray("categorias");

            // Mostrar categorías
            System.out.println("Categorías disponibles:");
            for (int i = 0; i < categorias.length(); i++) {
                JSONObject cat = categorias.getJSONObject(i);
                System.out.println(cat.getInt("id") + ". " + cat.getString("nombre"));
            }

            System.out.print("Ingrese el ID de la categoría donde eliminar el producto: ");
            int idCategoria = scanner.nextInt();
            scanner.nextLine(); // limpiar salto de línea

            // Buscar categoría
            JSONObject categoriaSeleccionada = null;
            for (int i = 0; i < categorias.length(); i++) {
                JSONObject cat = categorias.getJSONObject(i);
                if (cat.getInt("id") == idCategoria) {
                    categoriaSeleccionada = cat;
                    break;
                }
            }

            if (categoriaSeleccionada == null) {
                System.out.println("Categoría no encontrada.");
                return;
            }

            // Comprobar si tiene productos
            if (!categoriaSeleccionada.has("productos") || categoriaSeleccionada.getJSONArray("productos").length() == 0) {
                System.out.println("⚠️ Esta categoría no tiene productos para eliminar.");
                return;
            }

            // Mostrar productos de la categoría
            JSONArray productos = categoriaSeleccionada.getJSONArray("productos");
            System.out.println("Productos disponibles:");
            for (int i = 0; i < productos.length(); i++) {
                JSONObject prod = productos.getJSONObject(i);
                System.out.println(prod.getInt("id") + ". " + prod.getString("nombre"));
            }

            System.out.print("Ingrese el ID del producto a eliminar: ");
            int idProducto = scanner.nextInt();

            boolean eliminado = false;
            for (int i = 0; i < productos.length(); i++) {
                JSONObject prod = productos.getJSONObject(i);
                if (prod.getInt("id") == idProducto) {
                    productos.remove(i);
                    eliminado = true;
                    break;
                }
            }

            if (eliminado) {
                guardarJsonArchivo(json, ruta);
                System.out.println("Producto eliminado correctamente.");
            } else {
                System.out.println("No se encontró un producto con ese ID en la categoría seleccionada.");
            }

        } catch (Exception e) {
            e.printStackTrace();
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
