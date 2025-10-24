using Microsoft.Data.Sqlite;
using System;
using System.IO;
using System.Reflection;

namespace WpfAppNoSteam.Database
{
    public static class DatabaseHelper
    {
        // Ruta de la base de datos (en AppData para evitar problemas de permisos)
        public static string DbPath => Path.Combine(
            Environment.GetFolderPath(Environment.SpecialFolder.ApplicationData),
            "NoSteam", "nosteam.db");

        public static void InitializeDatabase()
        {
            Directory.CreateDirectory(Path.GetDirectoryName(DbPath)!);

            using var connection = new SqliteConnection($"Data Source={DbPath}");
            connection.Open();

            using (var pragma = new SqliteCommand("PRAGMA foreign_keys = ON;", connection))
                pragma.ExecuteNonQuery();

            string sqlScript = GetInitializationScript();

            foreach (string commandText in sqlScript.Split(';'))
            {
                if (string.IsNullOrWhiteSpace(commandText)) continue;

                using var cmd = new SqliteCommand(commandText.Trim() + ";", connection);
                try
                {
                    cmd.ExecuteNonQuery();
                }
                catch (Exception ex)
                {
                    System.Diagnostics.Debug.WriteLine($"Error ejecutando: {commandText}\n{ex.Message}");
                }
            }
        }

        private static string GetInitializationScript()
        {
            return @"
-- Borra tablas en orden inverso por claves foráneas
DROP TABLE IF EXISTS registro;
DROP TABLE IF EXISTS juego;
DROP TABLE IF EXISTS usuario;

-- Tabla juego: SIN estado
CREATE TABLE juego (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nombre TEXT NOT NULL,
    precio REAL NOT NULL
    
);

-- Tabla usuario: SIN nombre (solo email y contraseña)
CREATE TABLE usuario (
    email TEXT PRIMARY KEY,
    contraseña TEXT NOT NULL
);

-- Tabla registro: CON estado (por usuario + juego)
CREATE TABLE registro (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    fecha DATETIME DEFAULT (datetime('now')),
    email_fk TEXT NOT NULL,
    id_fk INTEGER NOT NULL,
    estado TEXT NOT NULL DEFAULT 'venta' 
        CHECK(estado IN ('venta', 'carrito', 'comprado')),
    FOREIGN KEY (email_fk) REFERENCES usuario(email) ON DELETE CASCADE,
    FOREIGN KEY (id_fk) REFERENCES juego(id) ON DELETE CASCADE
);

-- Datos iniciales: juegos (sin estado)
INSERT INTO juego (nombre, precio) VALUES 
('Pokemon ZA', 69.99),
('The Legend of Zelda', 59.99),
('Minecraft', 29.99),
('The Witcher 3', 39.99),
('Stardew Valley', 14.99);


-- Datos iniciales: usuarios (solo email y contraseña)
INSERT INTO usuario (email, contraseña) VALUES 
('admin@nosteam.com', 'admin123'),
('juan@ejemplo.com', 'juan123');
";
        }
    }
}