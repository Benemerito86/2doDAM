package com.mycompany.lecturajaxb;

import javax.xml.bind.annotation.XmlAccessType;
import javax.xml.bind.annotation.XmlAccessorType;
import javax.xml.bind.annotation.XmlAttribute;
import javax.xml.bind.annotation.XmlElement;
import javax.xml.bind.annotation.XmlType;

@XmlAccessorType(XmlAccessType.FIELD)
@XmlType(propOrder = {"nombre", "autor", "precio"})
public class Articulo {

    @XmlAttribute(name = "codigo")
    protected String codigo;

    @XmlElement(name = "nombre")
    protected String nombre;

    @XmlElement(name = "autor")
    protected String autor;

    @XmlElement(name = "precio")
    protected String precio;

    public Articulo() {}

    // Getters y Setters
    public String getCodigo() { return codigo; }
    public void setCodigo(String codigo) { this.codigo = codigo; }

    public String getNombre() { return nombre; }
    public void setNombre(String nombre) { this.nombre = nombre; }

    public String getAutor() { return autor; }
    public void setAutor(String autor) { this.autor = autor; }

    public String getPrecio() { return precio; }
    public void setPrecio(String precio) { this.precio = precio; }
}
