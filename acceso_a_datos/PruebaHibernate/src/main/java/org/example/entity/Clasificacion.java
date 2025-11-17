package org.example.entity;

import javax.persistence.*;
import java.util.HashSet;
import java.util.Set;

@Entity
@Table(name = "clasificaciones")
public class Clasificacion {

    @Id
    @Column(name = "codigo", length = 10, nullable = false)
    private String codigo;

    @Column(nullable = false)
    private String nombre;

    // Relación muchos a muchos con Animal
    @ManyToMany(mappedBy = "clasificaciones", fetch = FetchType.LAZY)
    private Set<Animal> animales = new HashSet<>();

    // Constructores
    public Clasificacion() {}

    public Clasificacion(String codigo, String nombre) {
        this.codigo = codigo;
        this.nombre = nombre;
    }

    // Getters y Setters
    public String getCodigo() { return codigo; }
    public void setCodigo(String codigo) { this.codigo = codigo; }

    public String getNombre() { return nombre; }
    public void setNombre(String nombre) { this.nombre = nombre; }

    public Set<Animal> getAnimales() { return animales; }
    public void setAnimales(Set<Animal> animales) { this.animales = animales; }

    @Override
    public String toString() {
        return "Clasificacion{" +
                "codigo='" + codigo + '\'' +
                ", nombre='" + nombre + '\'' +
                '}';
    }
}