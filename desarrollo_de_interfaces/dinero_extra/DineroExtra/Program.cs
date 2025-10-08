using DineroExtra;
using System;
using System.Collections.Generic;

namespace TiendaGastos
{
    class Program
    {
        static void Main(string[] args)
        {
            Console.WriteLine("BIENVENIDO A MI APP DE GESTIÓN DE GASTOS\n");

            // 1. Crear usuario
            Console.Write("Tu Nombre: ");
            string nombre = Console.ReadLine();

            int edad;
            while (true)
            {
                Console.Write("Tu Edad: ");
                if (int.TryParse(Console.ReadLine(), out edad))
                    break;
                Console.WriteLine("Por favor, necesitamos un número válido.");
            }

            Usuario usuario = new Usuario(nombre, edad);

            while (true)
            {
                Console.Write("DNI: ");
                string dni = Console.ReadLine();

                if (usuario.SetDni(dni))
                    break;
                else
                    Console.WriteLine("Formato de DNI INCORRECTO. Debe tener 8 números y una letra!");
            }

            // 2. Crear cuenta
            Cuenta cuenta = new Cuenta(usuario);

            // 3. Menú principal
            while (true)
            {
                Console.WriteLine("\n--- MENÚ ---");
                Console.WriteLine("1. Introducir ingreso");
                Console.WriteLine("2. Introducir gasto basico");
                Console.WriteLine("3. Introducir gasto extra");
                Console.WriteLine("4. Mostrar saldo y movimientos");
                Console.WriteLine("5. Mostrar ahorro de un período");
                Console.WriteLine("6. Mostrar gastos imprescindibles");
                Console.WriteLine("7. Mostrar posibles ahorros del mes pasado");
                Console.WriteLine("8. Añadir producto a lista de deseos");
                Console.WriteLine("9. Mostrar productos que puedes comprar");
                Console.WriteLine("0. Salir");
                Console.Write("Elige una opción: ");

                string opcion = Console.ReadLine();

                switch (opcion)
                {
                    case "1":
                        Console.Write("Descripción del ingreso: ");
                        string descIngreso = Console.ReadLine();

                        Console.Write("Cantidad: ");
                        if (double.TryParse(Console.ReadLine(), out double cantidadIngreso))
                        {
                            cuenta.AddIngreso(descIngreso, cantidadIngreso);
                            Console.WriteLine("Ingreso añadido correctamente.");
                        }
                        else
                        {
                            Console.WriteLine("Introduce una cantidad válida...");
                        }
                        break;

                    case "2":
                        Console.Write("Descripción del gasto: ");
                        string descGasto = Console.ReadLine();

                        Console.Write("Cantidad: ");
                        try
                        {
                            if (double.TryParse(Console.ReadLine(), out double cantidadGasto))
                            {
                                cuenta.AddGasto(descGasto, cantidadGasto, true);
                                Console.WriteLine("Gasto añadido correctamente.");
                            }
                            else
                            {
                                Console.WriteLine("Introduce una cantidad válida...");
                            }
                        }
                        catch (GastoException e)
                        {
                            Console.WriteLine("ERROR: " + e.Message);
                        }
                        break;
                    case "3":
                        Console.Write("Descripción del gasto extra: ");
                        string descGasto2 = Console.ReadLine();

                        Console.Write("Cantidad: ");
                        try
                        {
                            if (double.TryParse(Console.ReadLine(), out double cantidadGasto))
                            {
                                cuenta.AddGasto(descGasto2, cantidadGasto, false);
                                Console.WriteLine("Gasto añadido correctamente.");
                            }
                            else
                            {
                                Console.WriteLine("Introduce una cantidad válida...");
                            }
                        }
                        catch (GastoException e)
                        {
                            Console.WriteLine("ERROR: " + e.Message);
                        }
                        break;


                    case "4":
                        Console.WriteLine("\n--- ESTADO DE TU CUENTA ---");
                        Console.WriteLine(cuenta);

                        Console.WriteLine("\n--- INGRESOS ---");
                        Console.WriteLine(cuenta.GetIngresos());


                        Console.WriteLine("\n--- GASTOS ---");
                        Console.WriteLine(cuenta.GetGastos());

                        break;
                    case "5":
                        Console.WriteLine("\n--- AHORRO DE UN PERÍODO ---");
                        Console.Write("Introduce fecha de inicio (yyyy-mm-dd): ");
                        DateTime inicio = DateTime.Parse(Console.ReadLine());
                        Console.Write("Introduce fecha final (yyyy-mm-dd): ");
                        DateTime fin = DateTime.Parse(Console.ReadLine());

                        double ahorroPeriodo = CalcularAhorroPeriodo(cuenta, inicio, fin);
                        Console.WriteLine($"Tu ahorro entre {inicio:d} y {fin:d} es de {ahorroPeriodo:F2}€");
                        break;

                    case "6":
                        Console.WriteLine("\n--- GASTOS IMPRESCINDIBLES ---");
                        MostrarGastosImprescindibles(cuenta);
                        break;

                    case "7":
                        Console.WriteLine("\n--- POSIBLES AHORROS DEL MES PASADO ---");
                        MostrarAhorrosMesPasado(cuenta);
                        break;

                    case "8":
                        Console.WriteLine("\n--- AÑADIR PRODUCTO A LISTA DE DESEOS ---");
                        Console.Write("Nombre del producto: ");
                        string nombreProducto = Console.ReadLine();
                        Console.Write("Precio del producto: ");
                        if (double.TryParse(Console.ReadLine(), out double precioProducto))
                        {
                            Producto producto = new Producto(nombreProducto, precioProducto);
                            cuenta.AgregarProductoDeseado(producto);
                            Console.WriteLine("Producto añadido a la lista de deseos.");
                        }
                        else
                        {
                            Console.WriteLine("Introduce un precio válido...");
                        }


                        break;

                    case "9":
                        Console.WriteLine("\n--- PRODUCTOS QUE PUEDES COMPRAR ---");
                        Console.WriteLine(cuenta.GetProductosComprables());


                        break;

                    case "0":
                        Console.WriteLine("\nFin del programa.");
                        Console.WriteLine("Muy agradecido contigo. Buen día.");
                        return;

                    default:
                        Console.WriteLine("Esa opción no es válida. Inténtalo de nuevo.");
                        break;
                }
            }
        }
    
    static double CalcularAhorroPeriodo(Cuenta cuenta, DateTime inicio, DateTime fin)
        {
            double ingresos = 0;
            double gastos = 0;

            foreach (var ingreso in cuenta.Ingresos)
            {
                if (ingreso.Fecha >= inicio && ingreso.Fecha <= fin)
                    ingresos += ingreso.DineroValue;
            }

            foreach (var gasto in cuenta.Gastos)
            {
                if (gasto is GastoBasico gb && gb.Fecha >= inicio && gb.Fecha <= fin)
                    gastos += gb.DineroValue;
                if (gasto is GastoExtra ge && ge.Fecha >= inicio && ge.Fecha <= fin)
                    gastos += ge.DineroValue;
            }

            return ingresos - gastos;
        }

        static void MostrarGastosImprescindibles(Cuenta cuenta)
        {
            foreach (var gasto in cuenta.Gastos)
            {
                if (gasto is GastoExtra ge && ge.prescindible == false)
                    Console.WriteLine(ge);
            }
        }

        static void MostrarAhorrosMesPasado(Cuenta cuenta)
        {
            DateTime hoy = DateTime.Now;
            DateTime inicio = new DateTime(hoy.Year, hoy.Month, 1).AddMonths(-1);
            DateTime fin = new DateTime(hoy.Year, hoy.Month, 1).AddDays(-1);

            double ahorro = CalcularAhorroPeriodo(cuenta, inicio, fin);
            Console.WriteLine($"Tu ahorro del mes pasado ({inicio:MMM yyyy}) fue de {ahorro:F2}€");
        }

    }
}