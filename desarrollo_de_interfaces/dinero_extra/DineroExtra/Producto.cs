namespace TiendaGastos
{
    internal class Producto
    {
        public string Nombre { get; private set; }
        public double Precio { get; private set; }
        public Producto(string nombre, double precio)
        {
            Nombre = nombre;
            Precio = precio;
        }
        public override string ToString()
        {
            return $"{Nombre} - {Precio:F2}€";
        }
    }
}