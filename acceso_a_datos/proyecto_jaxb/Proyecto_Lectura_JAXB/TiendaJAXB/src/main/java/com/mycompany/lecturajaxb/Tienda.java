package com.mycompany.lecturajaxb;

import java.util.ArrayList;
import java.util.List;
import javax.xml.bind.annotation.XmlAccessType;
import javax.xml.bind.annotation.XmlAccessorType;
import javax.xml.bind.annotation.XmlElement;
import javax.xml.bind.annotation.XmlElementWrapper;
import javax.xml.bind.annotation.XmlElements;
import javax.xml.bind.annotation.XmlRootElement;
import javax.xml.bind.annotation.XmlType;

/**
 * Representa la tienda raíz del XML.
 */
@XmlRootElement(name = "tienda")
@XmlType(propOrder = {"nombre", "articulos"})
@XmlAccessorType(XmlAccessType.FIELD)
public class Tienda {

    @XmlElement(name = "nombre")
    private String nombre;

    @XmlElementWrapper(name = "articulos")
    @XmlElements({
            @XmlElement(name = "ram", type = Ram.class),
            @XmlElement(name = "memoria", type = Memoria.class),
            @XmlElement(name = "grafica", type = Grafica.class)
    })
    private List<Articulo> articulos = new ArrayList<>();

    public Tienda() {}

    public String getNombre() {
        return nombre;
    }

    public void setNombre(String nombre) {
        this.nombre = nombre;
    }

    public List<Articulo> getArticulos() {
        return articulos;
    }

    public void setArticulos(List<Articulo> articulos) {
        this.articulos = articulos;
    }
}
