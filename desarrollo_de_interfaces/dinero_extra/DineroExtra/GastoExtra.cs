using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using static System.Runtime.InteropServices.JavaScript.JSType;

namespace DineroExtra
{
    internal class GastoExtra : Gasto
    {
        public DateTime Fecha { get; private set; }
        public bool prescindible { get; private set; }
        public GastoExtra(double gasto, string description) : base(gasto, description)
        {
            Fecha = DateTime.Now;
            Console.WriteLine("¿Es un gasto prescindible? (s/n)");
            string respuesta = Console.ReadLine().ToLower();
            if (respuesta == "s" || respuesta == "si")
                prescindible = false;
            else
                prescindible = true;
        }
        public override string ToString()
        {
            return $"GASTO EXTRA: {DineroValue:F2}EU - {Description} - {Fecha} - Imprescindible: {prescindible}";
        }

    }
}
