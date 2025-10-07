package com.mycompany.lecturajaxb;

import javax.xml.bind.annotation.XmlRootElement;

@XmlRootElement(name = "grafica")
public class Grafica extends Articulo {

    public Grafica() {
        super();
    }

    public Grafica(String codigo, String nombre, String autor, String precio) {
        super();
        this.setCodigo(codigo);
        this.setNombre(nombre);
        this.setAutor(autor);
        this.setPrecio(precio);
    }
}