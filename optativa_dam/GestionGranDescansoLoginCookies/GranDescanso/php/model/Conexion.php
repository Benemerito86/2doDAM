<?php
class Conexion {
    private $host = "localhost"; # host de la base de datos
    private $db = "GranDescanso"; # nombre de base de datos
    private $user = "root"; # usuario de la base de datos
    private $pass = ""; # contraseña de la base de datos
    private $pdo;

    public function __construct() { # constructor de la clase
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->db};charset=utf8mb4";
            $this->pdo = new PDO($dsn, $this->user, $this->pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Conexión exitosa a la base de datos.";
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    public function getPDO() { # método para obtener la conexión PDO
        return $this->pdo;
    }
}
