using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace WpfAppNoSteam.Models
{
    internal class Juego
    {
        public int Id { get; set; }
        public string Nombre { get; set; } = string.Empty;
        public decimal Precio { get; set; }
        public string Estado { get; set; } = "venta"; 

  
        public string NombrePrecio => $"{Nombre} - {Precio:F2}€";
        public string ImagenPath => $"/{Nombre}.png";

    }
}