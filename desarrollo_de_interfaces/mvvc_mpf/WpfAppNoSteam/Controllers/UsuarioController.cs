using Microsoft.Data.Sqlite;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using WpfAppNoSteam.Database;

namespace WpfAppNoSteam.Controllers
{
    internal class UsuarioController
    {
        public bool RegistrarUsuario(string email, string contraseña)
        {
            // Validación básica
            if (string.IsNullOrWhiteSpace(email) ||
                string.IsNullOrWhiteSpace(contraseña))
                return false;

            // Verifica si el email ya existe
            if (UsuarioExiste(email))
                return false;

            const string sql = @"
                INSERT INTO usuario (email, contraseña) 
                VALUES (@email, @contraseña);";

            try
            {
                using var connection = new SqliteConnection($"Data Source={DatabaseHelper.DbPath}");
                connection.Open();

                using var command = new SqliteCommand(sql, connection);
                command.Parameters.AddWithValue("@email", email);
                command.Parameters.AddWithValue("@contraseña", contraseña); // ⚠️ En producción: hashea esto

                command.ExecuteNonQuery();
                return true;
            }
            catch (Exception ex)
            {
                System.Diagnostics.Debug.WriteLine($"Error al registrar usuario: {ex.Message}");
                return false;
            }
        }

        private bool UsuarioExiste(string email)
        {
            const string sql = "SELECT COUNT(1) FROM usuario WHERE email = @email;";
            using var connection = new SqliteConnection($"Data Source={DatabaseHelper.DbPath}");
            connection.Open();

            using var command = new SqliteCommand(sql, connection);
            command.Parameters.AddWithValue("@email", email);
            var result = command.ExecuteScalar();
            return Convert.ToInt32(result) > 0;
        }
        public bool LoginUsuario(string email, string contraseña)
        {
            const string sql = "SELECT COUNT(1) FROM usuario WHERE email = @email AND contraseña = @contraseña;";
            using var connection = new SqliteConnection($"Data Source={DatabaseHelper.DbPath}");
            connection.Open();
            using var command = new SqliteCommand(sql, connection);
            command.Parameters.AddWithValue("@email", email);
            command.Parameters.AddWithValue("@contraseña", contraseña);
            var result = command.ExecuteScalar();
            return Convert.ToInt32(result) > 0;
        }
        public bool CambiarContraseña(string email, string nuevaContraseña)
        {
            const string sql = "UPDATE usuario SET contraseña = @nuevaContraseña WHERE email = @email;";
            try
            {
                using var connection = new SqliteConnection($"Data Source={DatabaseHelper.DbPath}");
                connection.Open();
                using var command = new SqliteCommand(sql, connection);
                command.Parameters.AddWithValue("@nuevaContraseña", nuevaContraseña); // ⚠️ En producción: hashea esto
                command.Parameters.AddWithValue("@email", email);
                int filasAfectadas = command.ExecuteNonQuery();
                return filasAfectadas > 0;
            }
            catch (Exception ex)
            {
                System.Diagnostics.Debug.WriteLine($"Error al cambiar contraseña: {ex.Message}");
                return false;
            }
        }
    }
}
