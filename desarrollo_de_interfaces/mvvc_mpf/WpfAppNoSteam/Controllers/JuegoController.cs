// Controllers/JuegoController.cs
using Microsoft.Data.Sqlite;
using System.Collections.Generic;
using System.Data;
using WpfAppNoSteam.Database;
using WpfAppNoSteam.Models;

namespace WpfAppNoSteam.Controllers
{
    internal class JuegoController
    {
        // Obtiene todos los juegos, con el estado del usuario actual
        public List<Juego> ObtenerJuegosConEstadoUsuario(string emailUsuario)
        {
            var juegos = new List<Juego>();
            const string sql = @"
                SELECT 
                    j.id,
                    j.nombre,
                    j.precio,
                    COALESCE(r.estado, 'venta') AS estado
                FROM juego j
                LEFT JOIN registro r ON j.id = r.id_fk AND r.email_fk = @email;";

            using var connection = new SqliteConnection($"Data Source={DatabaseHelper.DbPath}");
            connection.Open();

            using var command = new SqliteCommand(sql, connection);
            command.Parameters.AddWithValue("@email", emailUsuario);

            using var reader = command.ExecuteReader();
            while (reader.Read())
            {
                juegos.Add(new Juego
                {
                    Id = reader.GetInt32("id"),
                    Nombre = reader.GetString("nombre"),
                    Precio = (decimal)reader.GetDouble("precio"),
                    Estado = reader.GetString("estado")
                });
            }

            return juegos;
        }

        // Añade o actualiza el estado de un juego para un usuario
        public void ActualizarEstadoJuego(string email, int idJuego, string nuevoEstado)
        {
            const string checkSql = "SELECT COUNT(1) FROM registro WHERE email_fk = @email AND id_fk = @id;";

            using var connection = new SqliteConnection($"Data Source={DatabaseHelper.DbPath}");
            connection.Open();

            using (var checkCmd = new SqliteCommand(checkSql, connection))
            {
                checkCmd.Parameters.AddWithValue("@email", email);
                checkCmd.Parameters.AddWithValue("@id", idJuego);
                bool existe = (long)checkCmd.ExecuteScalar() > 0;

                if (existe)
                {
                    const string updateSql = "UPDATE registro SET estado = @estado WHERE email_fk = @email AND id_fk = @id;";
                    using var updateCmd = new SqliteCommand(updateSql, connection);
                    updateCmd.Parameters.AddWithValue("@email", email);
                    updateCmd.Parameters.AddWithValue("@id", idJuego);
                    updateCmd.Parameters.AddWithValue("@estado", nuevoEstado);
                    updateCmd.ExecuteNonQuery();
                }
                else
                {
                    const string insertSql = "INSERT INTO registro (email_fk, id_fk, estado) VALUES (@email, @id, @estado);";
                    using var insertCmd = new SqliteCommand(insertSql, connection);
                    insertCmd.Parameters.AddWithValue("@email", email);
                    insertCmd.Parameters.AddWithValue("@id", idJuego);
                    insertCmd.Parameters.AddWithValue("@estado", nuevoEstado);
                    insertCmd.ExecuteNonQuery();
                }
            }
        }
        public List<Juego> ObtenerJuegosPorEstado(string emailUsuario, string estado)
        {
            var juegos = new List<Juego>();
            const string sql = @"
        SELECT j.id, j.nombre, j.precio
        FROM juego j
        INNER JOIN registro r ON j.id = r.id_fk
        WHERE r.email_fk = @email AND r.estado = @estado;";

            using var connection = new SqliteConnection($"Data Source={DatabaseHelper.DbPath}");
            connection.Open();

            using var command = new SqliteCommand(sql, connection);
            command.Parameters.AddWithValue("@email", emailUsuario);
            command.Parameters.AddWithValue("@estado", estado);

            using var reader = command.ExecuteReader();
            while (reader.Read())
            {
                juegos.Add(new Juego
                {
                    Id = reader.GetInt32("id"),
                    Nombre = reader.GetString("nombre"),
                    Precio = (decimal)reader.GetDouble("precio")
                });
            }

            return juegos;
        }
        public void AddJuego(string nombre, decimal precio)
        {
            const string sql = "INSERT INTO juego (nombre, precio) VALUES (@nombre, @precio);";
            using var connection = new SqliteConnection($"Data Source={DatabaseHelper.DbPath}");
            connection.Open();
            using var command = new SqliteCommand(sql, connection);
            command.Parameters.AddWithValue("@nombre", nombre);
            command.Parameters.AddWithValue("@precio", precio);
            command.ExecuteNonQuery();
        }
    }
}