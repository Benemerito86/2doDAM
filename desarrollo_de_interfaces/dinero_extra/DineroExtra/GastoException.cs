using System;

public class GastoException : Exception
{
    public GastoException(string mensaje = "Gasto NO PERMITIDO! El saldo es insuficiente.")
        : base(mensaje)
    {
    }
}