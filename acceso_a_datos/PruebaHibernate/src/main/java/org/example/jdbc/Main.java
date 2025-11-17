package org.example.jdbc;

import org.example.dao.AnimalDAO;
import org.example.dao.UsuarioDAO;
import org.example.dao.ClasificacionDAO;
import org.example.entity.Animal;
import org.example.entity.Usuario;
import org.example.entity.Clasificacion;

import java.util.Scanner;
import java.util.List;

public class Main {
    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);
        AnimalDAO animalDAO = new AnimalDAO();
        UsuarioDAO usuarioDAO = new UsuarioDAO();
        ClasificacionDAO clasificacionDAO = new ClasificacionDAO();

        while (true) {
            System.out.println("\n--- Menú Principal ---");
            System.out.println("1. Animales");
            System.out.println("2. Usuarios");
            System.out.println("3. Clasificaciones");
            System.out.println("4. Salir");
            System.out.print("Selecciona una opción: ");
            int opcion = scanner.nextInt();
            scanner.nextLine(); // Consumir nueva línea

            switch (opcion) {
                case 1:
                    menuAnimales(scanner, animalDAO, usuarioDAO, clasificacionDAO);
                    break;
                case 2:
                    menuUsuarios(scanner, usuarioDAO);
                    break;
                case 3:
                    menuClasificaciones(scanner, clasificacionDAO);
                    break;
                case 4:
                    System.out.println("Saliendo...");
                    scanner.close();
                    return;
                default:
                    System.out.println("Opción no válida.");
            }
        }
    }

    private static void menuAnimales(Scanner scanner, AnimalDAO animalDAO, UsuarioDAO usuarioDAO, ClasificacionDAO clasificacionDAO) {
        while (true) {
            System.out.println("\n--- Menú de Animales ---");
            System.out.println("1. Registrar nuevo animal");
            System.out.println("2. Buscar animal por especie");
            System.out.println("3. Actualizar estado de animal");
            System.out.println("4. Asignar usuario a animal");
            System.out.println("5. Asignar clasificación a animal");
            System.out.println("6. Ver todos los animales");
            System.out.println("7. Volver al menú principal");
            System.out.print("Selecciona una opción: ");
            int opcion = scanner.nextInt();
            scanner.nextLine(); // Consumir nueva línea

            switch (opcion) {
                case 1:
                    System.out.print("Nombre: ");
                    String nombre = scanner.nextLine();
                    System.out.print("Especie: ");
                    String especie = scanner.nextLine();
                    System.out.print("Edad: ");
                    int edad = scanner.nextInt();
                    scanner.nextLine();
                    System.out.print("Estado: ");
                    String estado = scanner.nextLine();
                    System.out.print("Descripción pérdida: ");
                    String descripcion = scanner.nextLine();

                    Animal animal = new Animal(nombre, especie, edad, estado, descripcion);

                    // Asignar usuario opcional
                    System.out.print("¿Asignar usuario? (s/n): ");
                    String respuesta = scanner.nextLine();
                    if (respuesta.equalsIgnoreCase("s")) {
                        System.out.print("DNI del usuario: ");
                        String dni = scanner.nextLine();
                        Usuario usuario = usuarioDAO.findByDni(dni);
                        if (usuario != null) {
                            animal.setUsuario(usuario);
                        } else {
                            System.out.println("Usuario no encontrado.");
                        }
                    }

                    // Asignar clasificaciones
                    System.out.print("¿Asignar clasificaciones? (s/n): ");
                    respuesta = scanner.nextLine();
                    if (respuesta.equalsIgnoreCase("s")) {
                        System.out.println("Clasificaciones disponibles:");
                        List<Clasificacion> clasificaciones = clasificacionDAO.findAll();
                        for (Clasificacion c : clasificaciones) {
                            System.out.println(c.getCodigo() + " - " + c.getNombre());
                        }
                        System.out.print("Introduce códigos separados por coma: ");
                        String codigos = scanner.nextLine();
                        String[] codigosArray = codigos.split(",");
                        for (String codigo : codigosArray) {
                            codigo = codigo.trim();
                            Clasificacion clasificacion = clasificacionDAO.findByCodigo(codigo);
                            if (clasificacion != null) {
                                animal.addClasificacion(clasificacion);
                            } else {
                                System.out.println("Clasificación " + codigo + " no encontrada.");
                            }
                        }
                    }

                    animalDAO.save(animal);
                    System.out.println("Animal registrado con ID: " + animal.getId());
                    break;

                case 2:
                    System.out.print("Especie a buscar: ");
                    String especieBuscar = scanner.nextLine();
                    animalDAO.findByEspecie(especieBuscar).forEach(System.out::println);
                    break;

                case 3:
                    System.out.print("ID del animal a actualizar: ");
                    Long id = scanner.nextLong();
                    scanner.nextLine();
                    Animal animalActualizar = animalDAO.findById(id);
                    if (animalActualizar != null) {
                        System.out.print("Nuevo estado: ");
                        String nuevoEstado = scanner.nextLine();
                        animalActualizar.setEstado(nuevoEstado);
                        animalDAO.update(animalActualizar);
                        System.out.println("Estado actualizado.");
                    } else {
                        System.out.println("Animal no encontrado.");
                    }
                    break;

                case 4:
                    System.out.print("ID del animal: ");
                    Long idAnimal = scanner.nextLong();
                    scanner.nextLine();
                    System.out.print("DNI del usuario: ");
                    String dniUsuario = scanner.nextLine();
                    Animal animalAsignar = animalDAO.findById(idAnimal);
                    Usuario usuarioAsignar = usuarioDAO.findByDni(dniUsuario);
                    if (animalAsignar != null && usuarioAsignar != null) {
                        animalAsignar.setUsuario(usuarioAsignar);
                        animalDAO.update(animalAsignar);
                        System.out.println("Usuario asignado al animal.");
                    } else {
                        System.out.println("Animal o usuario no encontrado.");
                    }
                    break;

                case 5:
                    System.out.print("ID del animal: ");
                    Long idAnimal2 = scanner.nextLong();
                    scanner.nextLine();
                    System.out.print("Código de clasificación: ");
                    String codigoClasif = scanner.nextLine();
                    Animal animalClasif = animalDAO.findById(idAnimal2);
                    Clasificacion clasif = clasificacionDAO.findByCodigo(codigoClasif);
                    if (animalClasif != null && clasif != null) {
                        animalClasif.addClasificacion(clasif);
                        animalDAO.update(animalClasif);
                        System.out.println("Clasificación asignada al animal.");
                    } else {
                        System.out.println("Animal o clasificación no encontrada.");
                    }
                    break;

                case 6:
                    animalDAO.findAll().forEach(System.out::println);
                    break;

                case 7:
                    return;

                default:
                    System.out.println("Opción no válida.");
            }
        }
    }

    private static void menuUsuarios(Scanner scanner, UsuarioDAO dao) {
        while (true) {
            System.out.println("\n--- Menú de Usuarios ---");
            System.out.println("1. Registrar nuevo usuario");
            System.out.println("2. Ver todos los usuarios");
            System.out.println("3. Volver al menú principal");
            System.out.print("Selecciona una opción: ");
            int opcion = scanner.nextInt();
            scanner.nextLine(); // Consumir nueva línea

            switch (opcion) {
                case 1:
                    System.out.print("DNI: ");
                    String dni = scanner.nextLine();
                    System.out.print("Nombre: ");
                    String nombre = scanner.nextLine();
                    System.out.print("Email: ");
                    String email = scanner.nextLine();
                    Usuario usuario = new Usuario(dni, nombre, email);
                    dao.save(usuario);
                    System.out.println("Usuario registrado.");
                    break;

                case 2:
                    dao.findAll().forEach(System.out::println);
                    break;

                case 3:
                    return;

                default:
                    System.out.println("Opción no válida.");
            }
        }
    }

    private static void menuClasificaciones(Scanner scanner, ClasificacionDAO dao) {
        while (true) {
            System.out.println("\n--- Menú de Clasificaciones ---");
            System.out.println("1. Registrar nueva clasificación");
            System.out.println("2. Ver todas las clasificaciones");
            System.out.println("3. Volver al menú principal");
            System.out.print("Selecciona una opción: ");
            int opcion = scanner.nextInt();
            scanner.nextLine(); // Consumir nueva línea

            switch (opcion) {
                case 1:
                    System.out.print("Código: ");
                    String codigo = scanner.nextLine();
                    System.out.print("Nombre: ");
                    String nombre = scanner.nextLine();
                    Clasificacion clasificacion = new Clasificacion(codigo, nombre);
                    dao.save(clasificacion);
                    System.out.println("Clasificación registrada.");
                    break;

                case 2:
                    dao.findAll().forEach(System.out::println);
                    break;

                case 3:
                    return;

                default:
                    System.out.println("Opción no válida.");
            }
        }
    }
}