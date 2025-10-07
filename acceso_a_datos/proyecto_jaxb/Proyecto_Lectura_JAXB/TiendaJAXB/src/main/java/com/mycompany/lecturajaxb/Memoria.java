package com.mycompany.lecturajaxb;

import javax.xml.bind.annotation.XmlRootElement;

@XmlRootElement(name = "memoria")
public class Memoria extends Articulo {

    public Memoria() {
        super();
    }

    public Memoria(String codigo, String nombre, String autor, String precio) {
        super();
        this.setCodigo(codigo);
        this.setNombre(nombre);
        this.setAutor(autor);
        this.setPrecio(precio);
    }
}
