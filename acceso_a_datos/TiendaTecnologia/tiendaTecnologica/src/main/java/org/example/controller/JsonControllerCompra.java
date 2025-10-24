package org.example.controller;

import org.json.JSONArray;
import org.json.JSONObject;

import java.io.FileWriter;
import java.io.IOException;
import java.nio.charset.StandardCharsets;
import java.nio.file.Files;
import java.nio.file.Paths;
import java.util.Scanner;

public class JsonControllerCompra {

    public static void añadirCompra() {
        try {
            Scanner scanner = new Scanner(System.in);
            String ruta = "src/main/java/org/example/tienda.json";
            JSONObject json = leerJsonDesdeArchivo(ruta);
            JSONObject tienda = json.getJSONObject("tienda");

            if (!tienda.has("usuarios") || tienda.getJSONArray("usuarios").length() == 0) {
                System.out.println("No hay usuarios registrados para añadir una compra.");
                return;
            }

            JSONArray usuarios = tienda.getJSONArray("usuarios");

            // Mostrar usuarios
            System.out.println("Usuarios disponibles:");
            for (int i = 0; i < usuarios.length(); i++) {
                JSONObject usuario = usuarios.getJSONObject(i);
                System.out.println(usuario.getInt("id") + ". " + usuario.getString("nombre"));
            }

            System.out.print("Ingrese el ID del usuario que realiza la compra: ");
            int idUsuario = scanner.nextInt();
            scanner.nextLine(); // limpiar salto de línea

            // Buscar usuario
            JSONObject usuarioSeleccionado = null;
            for (int i = 0; i < usuarios.length(); i++) {
                JSONObject usuario = usuarios.getJSONObject(i);
                if (usuario.getInt("id") == idUsuario) {
                    usuarioSeleccionado = usuario;
                    break;
                }
            }

            if (usuarioSeleccionado == null) {
                System.out.println("Usuario no encontrado.");
                return;
            }

            // Obtener historial de compras
            JSONArray historial;
            if (usuarioSeleccionado.has("historialCompras")) {
                historial = usuarioSeleccionado.getJSONArray("historialCompras");
            } else {
                historial = new JSONArray();
                usuarioSeleccionado.put("historialCompras", historial);
            }

            // Pedir datos de la compra
            System.out.print("Ingrese el ID del producto: ");
            int productoId = scanner.nextInt();
            System.out.print("Cantidad: ");
            int cantidad = scanner.nextInt();
            scanner.nextLine(); // limpiar salto de línea
            System.out.print("Fecha (YYYY-MM-DD): ");
            String fecha = scanner.nextLine();

            // Crear objeto de compra
            JSONObject nuevaCompra = new JSONObject();
            nuevaCompra.put("productoId", productoId);
            nuevaCompra.put("cantidad", cantidad);
            nuevaCompra.put("fecha", fecha);

            // Añadir al historial
            historial.put(nuevaCompra);

            // Guardar cambios
            guardarJsonArchivo(json, ruta);

            System.out.println("Compra añadida correctamente al usuario " + usuarioSeleccionado.getString("nombre"));

        } catch (Exception e) {
            e.printStackTrace();
        }

    }
    public static void eliminarCompra() {
        try {
            Scanner scanner = new Scanner(System.in);
            String ruta = "src/main/java/org/example/tienda.json";
            JSONObject json = leerJsonDesdeArchivo(ruta);
            JSONObject tienda = json.getJSONObject("tienda");

            if (!tienda.has("usuarios") || tienda.getJSONArray("usuarios").length() == 0) {
                System.out.println("No hay usuarios registrados.");
                return;
            }

            JSONArray usuarios = tienda.getJSONArray("usuarios");

            // Mostrar usuarios
            System.out.println("Usuarios disponibles:");
            for (int i = 0; i < usuarios.length(); i++) {
                JSONObject usuario = usuarios.getJSONObject(i);
                System.out.println(usuario.getInt("id") + ". " + usuario.getString("nombre"));
            }

            System.out.print("Ingrese el ID del usuario: ");
            int idUsuario = scanner.nextInt();
            scanner.nextLine(); // limpiar salto de línea

            // Buscar usuario
            JSONObject usuarioSeleccionado = null;
            for (int i = 0; i < usuarios.length(); i++) {
                JSONObject usuario = usuarios.getJSONObject(i);
                if (usuario.getInt("id") == idUsuario) {
                    usuarioSeleccionado = usuario;
                    break;
                }
            }

            if (usuarioSeleccionado == null) {
                System.out.println("Usuario no encontrado.");
                return;
            }

            // Comprobar historial de compras
            if (!usuarioSeleccionado.has("historialCompras") || usuarioSeleccionado.getJSONArray("historialCompras").length() == 0) {
                System.out.println("Este usuario no tiene compras para eliminar.");
                return;
            }

            JSONArray historial = usuarioSeleccionado.getJSONArray("historialCompras");

            // Mostrar historial
            System.out.println("Historial de compras:");
            for (int i = 0; i < historial.length(); i++) {
                JSONObject compra = historial.getJSONObject(i);
                System.out.println(compra.getInt("productoId") + ". Cantidad: " + compra.getInt("cantidad") + ", Fecha: " + compra.getString("fecha"));
            }

            System.out.print("Ingrese el ID del producto de la compra a eliminar: ");
            int idProducto = scanner.nextInt();

            boolean eliminado = false;
            for (int i = 0; i < historial.length(); i++) {
                JSONObject compra = historial.getJSONObject(i);
                if (compra.getInt("productoId") == idProducto) {
                    historial.remove(i);
                    eliminado = true;
                    break;
                }
            }

            if (eliminado) {
                guardarJsonArchivo(json, ruta);
                System.out.println("Compra eliminada.");
            } else {
                System.out.println("No se encontró ninguna compra con ese ID de producto.");
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
