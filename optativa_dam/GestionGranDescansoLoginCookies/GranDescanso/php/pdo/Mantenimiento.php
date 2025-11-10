<?php
require_once '../model/Conexion.php';

class Mantenimiento {# Clase para manejar los mantenimientos
    /* En esta clase se implementan los métodos CRUD para la tabla Mantenimiento, las funciones son:
        - obtenerMantenimientos(): Obtener todos los mantenimientos
        - agregar($habitacion_numero, $inicio, $fin, $descripcion): Agregar un nuevo mantenimiento
        - borrar($id): Borrar un mantenimiento
        - actualizar($id, $habitacion_numero, $inicio, $fin, $descripcion): Actualizar un mantenimiento
    */
    private $pdo;

    public function __construct() {
        $this->pdo = (new Conexion())->getPDO();
    }
    public function obtenerMantenimientos() {
        $stmt = $this->pdo->query("SELECT id, habitacion_numero, inicio, fin, descripcion FROM Mantenimiento");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function agregar($habitacion_numero, $inicio, $fin, $descripcion) {
        $stmt = $this->pdo->prepare("INSERT INTO Mantenimiento (habitacion_numero, inicio, fin, descripcion) VALUES (?, ?, ?, ?)");
        $stmt->execute([$habitacion_numero, $inicio, $fin, $descripcion]);
    }
    public function borrar($id) {
        $stmt = $this->pdo->prepare("DELETE FROM Mantenimiento WHERE id = ?");
        $stmt->execute([$id]);
    }
    public function actualizar($id, $habitacion_numero, $inicio, $fin, $descripcion) {
        $stmt = $this->pdo->prepare("UPDATE Mantenimiento SET habitacion_numero = ?, inicio = ?, fin = ?, descripcion = ? WHERE id = ?");
        $stmt->execute([$habitacion_numero, $inicio, $fin, $descripcion, $id]);
    }
    

}

?>