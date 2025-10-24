package org.example.controller;

import org.json.JSONArray;
import org.json.JSONObject;

import java.io.FileWriter;
import java.nio.charset.StandardCharsets;
import java.nio.file.Files;
import java.nio.file.Paths;
import java.util.Scanner;

public class JsonControllerUsuario {

    public static void verUsuarios() {
        try {
            String ruta = "src/main/java/org/example/tienda.json";
            JSONObject json = leerJsonDesdeArchivo(ruta);

            JSONObject tienda = json.getJSONObject("tienda");

            // Comprobar si existen usuarios
            if (!tienda.has("usuarios") || tienda.getJSONArray("usuarios").length() == 0) {
                System.out.println("No hay usuarios registrados.");
                return;
            }

            JSONArray usuarios = tienda.getJSONArray("usuarios");

            for (int i = 0; i < usuarios.length(); i++) {
                JSONObject usuario = usuarios.getJSONObject(i);

                int id = usuario.getInt("id");
                String nombre = usuario.getString("nombre");
                String email = usuario.getString("email");

                JSONObject direccion = usuario.getJSONObject("direccion");
                String calle = direccion.getString("calle");
                int numero = direccion.getInt("numero");
                String ciudad = direccion.getString("ciudad");
                String pais = direccion.getString("pais");

                System.out.println("Usuario ID: " + id);
                System.out.println("Nombre: " + nombre);
                System.out.println("Email: " + email);
                System.out.println("Dirección: " + calle + " " + numero + ", " + ciudad + ", " + pais);

                // Historial de compras
                if (usuario.has("historialCompras") && usuario.getJSONArray("historialCompras").length() > 0) {
                    JSONArray historial = usuario.getJSONArray("historialCompras");
                    System.out.println("Historial de compras:");
                    for (int j = 0; j < historial.length(); j++) {
                        JSONObject compra = historial.getJSONObject(j);
                        int productoId = compra.getInt("productoId");
                        int cantidad = compra.getInt("cantidad");
                        String fecha = compra.getString("fecha");

                        System.out.println("  Producto ID: " + productoId + ", Cantidad: " + cantidad + ", Fecha: " + fecha);
                    }
                } else {
                    System.out.println("No tiene historial de compras.");
                }

                System.out.println("----------------------------------");
            }

        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    public static void añadirUsuario() {
        try {
            Scanner scanner = new Scanner(System.in);
            String ruta = "src/main/java/org/example/tienda.json";
            JSONObject json = leerJsonDesdeArchivo(ruta);
            JSONObject tienda = json.getJSONObject("tienda");

            // Crear array de usuarios si no existe
            JSONArray usuarios;
            if (tienda.has("usuarios")) {
                usuarios = tienda.getJSONArray("usuarios");
            } else {
                usuarios = new JSONArray();
                tienda.put("usuarios", usuarios);
            }

            // Pedir datos del usuario
            System.out.print("Nombre del usuario: ");
            String nombre = scanner.nextLine();

            System.out.print("Email: ");
            String email = scanner.nextLine();

            System.out.println("Dirección:");
            System.out.print("  Calle: ");
            String calle = scanner.nextLine();
            System.out.print("  Número: ");
            int numero = scanner.nextInt();
            scanner.nextLine(); // limpiar salto de línea
            System.out.print("  Ciudad: ");
            String ciudad = scanner.nextLine();
            System.out.print("  País: ");
            String pais = scanner.nextLine();

            // Generar ID único
            int maxId = 0;
            for (int i = 0; i < usuarios.length(); i++) {
                int idActual = usuarios.getJSONObject(i).getInt("id");
                if (idActual > maxId) maxId = idActual;
            }
            int nuevoId = maxId + 1;

            // Crear objeto usuario
            JSONObject nuevoUsuario = new JSONObject();
            nuevoUsuario.put("id", nuevoId);
            nuevoUsuario.put("nombre", nombre);
            nuevoUsuario.put("email", email);

            JSONObject direccion = new JSONObject();
            direccion.put("calle", calle);
            direccion.put("numero", numero);
            direccion.put("ciudad", ciudad);
            direccion.put("pais", pais);

            nuevoUsuario.put("direccion", direccion);

            // Historial de compras vacío
            nuevoUsuario.put("historialCompras", new JSONArray());

            // Añadir usuario al array
            usuarios.put(nuevoUsuario);

            // Guardar cambios en el JSON
            guardarJsonArchivo(json, ruta);

            System.out.println("✅ Usuario añadido correctamente con ID = " + nuevoId);

        } catch (Exception e) {
            e.printStackTrace();
        }

    }
    public static void eliminarUsuario() {
        try {
            Scanner scanner = new Scanner(System.in);
            String ruta = "src/main/java/org/example/tienda.json";
            JSONObject json = leerJsonDesdeArchivo(ruta);

            JSONObject tienda = json.getJSONObject("tienda");

            // Comprobar si hay usuarios
            if (!tienda.has("usuarios") || tienda.getJSONArray("usuarios").length() == 0) {
                System.out.println("No hay usuarios para eliminar.");
                return;
            }

            JSONArray usuarios = tienda.getJSONArray("usuarios");

            // Mostrar usuarios
            System.out.println("Usuarios disponibles:");
            for (int i = 0; i < usuarios.length(); i++) {
                JSONObject usuario = usuarios.getJSONObject(i);
                System.out.println(usuario.getInt("id") + ". " + usuario.getString("nombre"));
            }

            System.out.print("Ingrese el ID del usuario a eliminar: ");
            int idUsuario = scanner.nextInt();

            boolean eliminado = false;
            for (int i = 0; i < usuarios.length(); i++) {
                JSONObject usuario = usuarios.getJSONObject(i);
                if (usuario.getInt("id") == idUsuario) {
                    usuarios.remove(i);
                    eliminado = true;
                    break;
                }
            }

            if (eliminado) {
                guardarJsonArchivo(json, ruta);
                System.out.println("Usuario eliminado correctamente.");
            } else {
                System.out.println("No se encontró un usuario con ese ID.");
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
