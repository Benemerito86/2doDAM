/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 */

package com.mycompany.lecturajaxb;

import javax.xml.bind.JAXBContext;
import javax.xml.bind.JAXBException;
import javax.xml.bind.Unmarshaller;
import java.io.File;
import java.util.List;
import java.util.Scanner;

public class TiendaJAXB {

    public static void main(String[] args) {
        try {
            //Conectar con el xml
            String basePath = System.getProperty("user.dir");
            String xmlPath = basePath + File.separator +
                    "TiendaJAXB" + File.separator +
                    "src" + File.separator +
                    "main" + File.separator +
                    "java" + File.separator +
                    "com" + File.separator +
                    "mycompany" + File.separator +
                    "lecturajaxb" + File.separator +
                    "datos.xml";

            File xmlFile = new File(xmlPath);

            if (!xmlFile.exists()) {
                System.err.println("No se encontró el archivo XML en: " + xmlFile.getAbsolutePath());
                return;
            }

            JAXBContext context = JAXBContext.newInstance(Tienda.class, Ram.class, Memoria.class, Grafica.class);
            Unmarshaller unmarshaller = context.createUnmarshaller();

            Tienda tienda = (Tienda) unmarshaller.unmarshal(xmlFile);
            System.out.println("Archivo XML cargado correctamente.");
            System.out.println("Tienda: " + tienda.getNombre());
            System.out.println();


            //menu tienda
            Scanner sc = new Scanner(System.in);
            boolean flag = false;

            do{

                System.out.println("SISTEMA DE GESTIÓN DE TIENDA" +
                        "\n1. Mostrar catálogo completo " +
                        "\n2. Mostrar memorias " +
                        "\n3. Mostrar gráficas " +
                        "\n4. Mostrar RAM " +
                        "\n5. Salir");

                int opcion = sc.nextInt();
                sc.nextLine();

                switch (opcion) {
                    case 1 -> catalogo(tienda.getArticulos());
                    case 2 -> tipo(tienda.getArticulos(), Memoria.class);
                    case 3 -> tipo(tienda.getArticulos(), Grafica.class);
                    case 4 -> tipo(tienda.getArticulos(), Ram.class);
                    case 5 -> {
                        System.out.println("Saliendo");
                        flag = true;
                    }
                    default -> System.out.println("Opción no válida.");
                }
            }while (!flag);

        } catch (JAXBException e) {
            System.err.println("Error al leer el XML: " + e.getMessage());
        }
    }

    private static void catalogo(List<Articulo> articulos) {
        System.out.println("\nCatálogo:");
        articulos.forEach(TiendaJAXB::mostrarArticulo);
        System.out.println();
    }

    private static void tipo(List<Articulo> articulos, Class<?> tipo) {
        System.out.println("\n🔍 Mostrando " + tipo.getSimpleName() + "s:\n");
        articulos.stream()
                .filter(a -> a.getClass().equals(tipo))
                .forEach(TiendaJAXB::mostrarArticulo);
        System.out.println();
    }



    private static void mostrarArticulo(Articulo a) {
        System.out.println("Código: " + a.getCodigo());
        System.out.println("Producto: " + a.getNombre());
        System.out.println("Especificaciones: " + a.getAutor());
        System.out.println("Precio: " + a.getPrecio());
        System.out.println("----------------------------");
    }
}
