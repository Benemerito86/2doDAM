using System;

// Clase Ingreso que hereda de Dinero
public class Ingreso : Dinero
{

    public DateTime Fecha { get; private set; }

    // Constructor
    public Ingreso(double ingreso, string description)
        : base(ingreso, description)
    {
        Fecha = DateTime.Now;

    }
    // Representación en texto
    public override string ToString()
    {
        return $"INGRESO: {DineroValue:F2}EU - {Description} - {Fecha}";
    }
}
