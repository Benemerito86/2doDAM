<?php
class Conexion {
    private $host = "localhost";
    private $db = "GranDescanso";
    private $user = "root";
    private $pass = "";
    private $pdo;

    public function __construct() {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->db};charset=utf8mb4";
            $this->pdo = new PDO($dsn, $this->user, $this->pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Conexión exitosa a la base de datos.";
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    public function getPDO() {
        return $this->pdo;
    }
}
