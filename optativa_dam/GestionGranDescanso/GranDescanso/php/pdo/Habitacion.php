<?php
require_once '../model/Conexion.php';

class Habitacion {
    private $pdo;

    public function __construct() {
        $this->pdo = (new Conexion())->getPDO();
    }

    public function obtenerTodas() {
        $stmt = $this->pdo->query("SELECT numero, tipo, precio_base FROM habitaciones");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function agregar($numero, $tipo, $precio) {
        $stmt = $this->pdo->prepare("INSERT INTO habitaciones (numero, tipo, precio_base) VALUES (?, ?, ?)");
        $stmt->execute([$numero, $tipo, $precio]);
    }
    public function borrar($numero) {
        $stmt = $this->pdo->prepare("DELETE FROM habitaciones WHERE numero = ?");
        $stmt->execute([$numero]);
    }
    public function actualizar($numero, $tipo, $precio) {
        $stmt = $this->pdo->prepare("UPDATE habitaciones SET tipo = ?, precio_base = ? WHERE numero = ?");
        $stmt->execute([$tipo, $precio, $numero]);
    }
}

?>