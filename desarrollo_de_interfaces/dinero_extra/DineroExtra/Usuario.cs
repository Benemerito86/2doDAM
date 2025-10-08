using System.Text.RegularExpressions;

namespace TiendaGastos
{
    /// <summary>
    /// Clase que representa al usuario de la aplicación, con nombre, edad y DNI validado.
    /// </summary>
    public class Usuario
    {
        public string Nombre { get; set; }
        public int Edad { get; set; }
        public string Dni { get; private set; }

        public Usuario(string nombre, int edad)
        {
            Nombre = nombre;
            Edad = edad;
            Dni = null;
        }

        /// <summary>
        /// Establece el DNI si cumple con el formato correcto (8 dígitos y una letra final).
        /// Permite opcionalmente un guion entre los números y la letra.
        /// </summary>
        public bool SetDni(string dni)
        {
            string patron = @"^\d{8}-?[A-Z]$";
            if (Regex.IsMatch(dni, patron))
            {
                // Eliminamos el guion si existe
                Dni = dni.Replace("-", "");
                return true;
            }
            else
            {
                return false;
            }
        }

        public override string ToString()
        {
            string dniStr = Dni != null ? Dni : "No asignado";
            return $"Usuario: {Nombre}, Edad: {Edad}, DNI: {dniStr}";
        }


    }
}

