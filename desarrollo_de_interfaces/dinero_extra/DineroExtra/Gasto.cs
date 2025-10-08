using System;

public class Gasto : Dinero
{
    public Gasto(double gasto, string description)
        : base(gasto, description)
    {
    }

    public override string ToString()
    {
        return $"GASTO BASICO: {DineroValue:F2}EU - {Description}";
    }
}
