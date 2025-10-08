using DineroExtra;
using System;
using System.Collections.Generic;

namespace TiendaGastos
{
    public class Cuenta
    {
        private double _saldo;
        private Usuario _usuario;
        private List<Gasto> _gastos;
        private List<GastoBasico> _gastosB;
        private List<GastoExtra> _gastosE;
        private List<Ingreso> _ingresos;
        private List<Producto> _listaDeseos;
        public Cuenta(Usuario usuario)
        {
            _usuario = usuario;
            _saldo = 0.0;
            _gastosB = new List<GastoBasico>();
            _gastosE = new List<GastoExtra>();
            _gastos = new List<Gasto>();
            _ingresos = new List<Ingreso>();
            _listaDeseos = new List<Producto>();
        }

        

        public double Saldo => _saldo;
        public Usuario Usuario => _usuario;
        public List<Gasto> Gastos => _gastos;

        
        public List<Ingreso> Ingresos => _ingresos;

        public String GetGastos()
        {
            if (_gastos.Count == 0) return "No hay gastos registrados.";
            string result = "Gastos:\n";
            foreach (var gasto in _gastos)
            {
                result += gasto.ToString() + "\n";
            }
            return result;
        }


        public String GetIngresos()
        {
            if (_ingresos.Count == 0) return "No hay ingresos registrados.";
            string result = "Ingresos:\n";
            foreach (var ingreso in _ingresos)
            {
                result += ingreso.ToString() + "\n";
            }
            return result;
        }

        public double AddIngreso(string description, double cantidad)
        {
            if (cantidad < 0) throw new ArgumentException("El ingreso debe ser positivo.");
            Ingreso ingreso = new Ingreso(cantidad, description);
            _ingresos.Add(ingreso);
            _saldo += cantidad;
            return _saldo;
        }

        public double AddGasto(string description, double cantidad, Boolean tipo)
        {
            if (cantidad < 0) throw new ArgumentException("El gasto debe ser positivo.");
            if (_saldo >= cantidad)
            {
                if (tipo){
                    Gasto gasto = new GastoBasico(cantidad, description);
                    _gastos.Add(gasto);
                }
                else {

                    Gasto gasto = new GastoExtra(cantidad, description);
                    _gastos.Add(gasto);

                }

                _saldo -= cantidad;
                return _saldo;
            }
            else
            {
                throw new GastoException("Te falta saldo para realizar ese gasto...");
            }
        }

        public override string ToString()
        {
            return $"{_usuario}\nSaldo actual: {_saldo:F2}EU";
        }


        internal void AgregarProductoDeseado(Producto producto)
        {
            _listaDeseos.Add(producto);
        }

        public string GetListaDeseos()
        {
            if (_listaDeseos.Count == 0) return "No tienes productos en tu lista de deseos.";
            string result = "LISTA DE DESEOS:\n";
            foreach (var p in _listaDeseos)
                result += p.ToString() + "\n";
            return result;
        }

        public string GetProductosComprables()
        {
            if (_listaDeseos.Count == 0) return "Tu lista de deseos está vacía.";
            string result = $"Productos que puedes comprar (saldo: {_saldo:F2}EU):\n";
            bool alguno = false;
            foreach (var p in _listaDeseos)
            {
                if (p.Precio <= _saldo)
                {
                    result += p.ToString() + "\n";
                    alguno = true;
                }
            }
            if (!alguno)
                result += "No puedes comprar ningún producto todavía.";
            return result;
        }

    }
}
