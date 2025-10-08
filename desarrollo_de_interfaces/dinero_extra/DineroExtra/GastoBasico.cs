using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace DineroExtra
{
    internal class GastoBasico : Gasto
    {
        public DateTime Fecha { get; private set; }

        public GastoBasico(double gasto, string description) : base(gasto, description)
        {
            Fecha = DateTime.Now;
        }
        public override string ToString()
        {
            return $"GASTO: {DineroValue:F2}EU - {Description} - {Fecha}";
        }

    }
}
