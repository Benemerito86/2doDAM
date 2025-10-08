using System;

// Clase base abstracta
public abstract class Dinero
{
    // Propiedades protegidas para herencia
    public double DineroValue { get; set; }
    public string Description { get; set; }

    // Constructor
    protected Dinero(double dinero, string description)
    {
        DineroValue = dinero;
        Description = description;
    }

    // Método abstracto que debe implementar cada derivada
    public abstract override string ToString();
}
