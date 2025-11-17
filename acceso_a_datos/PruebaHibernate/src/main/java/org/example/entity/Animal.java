package org.example.entity;

import javax.persistence.*;
import java.util.HashSet;
import java.util.Set;

@Entity
@Table(name = "animales")
public class Animal {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    @Column(nullable = false)
    private String nombre;

    @Column(nullable = false)
    private String especie;

    @Column(nullable = false)
    private int edad;

    @Column(nullable = false)
    private String estado; // "recién abandonado", "tiempo en el refugio", "próximamente en acogida"

    @Column(length = 500)
    private String descripcionPerdida;

    // Relación con Usuario (dueño)
    @ManyToOne(fetch = FetchType.EAGER)
    @JoinColumn(name = "usuario_dni", referencedColumnName = "dni")
    private Usuario usuario;

    // Relación muchos a muchos con Clasificacion
    @ManyToMany(cascade = {CascadeType.PERSIST, CascadeType.MERGE})
    @JoinTable(
            name = "animal_clasificacion",
            joinColumns = @JoinColumn(name = "animal_id"),
            inverseJoinColumns = @JoinColumn(name = "clasificacion_id")
    )
    private Set<Clasificacion> clasificaciones = new HashSet<>();

    // Constructores
    public Animal() {}

    public Animal(String nombre, String especie, int edad, String estado, String descripcionPerdida) {
        this.nombre = nombre;
        this.especie = especie;
        this.edad = edad;
        this.estado = estado;
        this.descripcionPerdida = descripcionPerdida;
    }

    // Getters y Setters
    public Long getId() { return id; }
    public void setId(Long id) { this.id = id; }

    public String getNombre() { return nombre; }
    public void setNombre(String nombre) { this.nombre = nombre; }

    public String getEspecie() { return especie; }
    public void setEspecie(String especie) { this.especie = especie; }

    public int getEdad() { return edad; }
    public void setEdad(int edad) { this.edad = edad; }

    public String getEstado() { return estado; }
    public void setEstado(String estado) { this.estado = estado; }

    public String getDescripcionPerdida() { return descripcionPerdida; }
    public void setDescripcionPerdida(String descripcionPerdida) { this.descripcionPerdida = descripcionPerdida; }

    public Usuario getUsuario() { return usuario; }
    public void setUsuario(Usuario usuario) { this.usuario = usuario; }

    public Set<Clasificacion> getClasificaciones() { return clasificaciones; }
    public void setClasificaciones(Set<Clasificacion> clasificaciones) { this.clasificaciones = clasificaciones; }

    public void addClasificacion(Clasificacion clasificacion) {
        this.clasificaciones.add(clasificacion);
        clasificacion.getAnimales().add(this);
    }


    @Override
    public String toString() {
        return "Animal{" +
                "id=" + id +
                ", nombre='" + nombre + '\'' +
                ", especie='" + especie + '\'' +
                ", edad=" + edad +
                ", estado='" + estado + '\'' +
                ", descripcionPerdida='" + descripcionPerdida + '\'' +
                ", usuario=" + (usuario != null ? usuario.getNombre() : "sin dueño") +
                '}';
    }
}