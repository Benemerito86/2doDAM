package com.mycompany.lecturajaxb;

import javax.xml.bind.annotation.XmlRootElement;

@XmlRootElement(name = "ram")
public class Ram extends Articulo {

    public Ram() {
        super();
    }

    public Ram(String codigo, String nombre, String autor, String precio) {
        super();
        this.setCodigo(codigo);
        this.setNombre(nombre);
        this.setAutor(autor);
        this.setPrecio(precio);
    }
}
