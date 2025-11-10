<?php
require_once '../model/Conexion.php';

class Huesped {# Clase para manejar los huéspedes
    /* En esta clase se implementan los métodos CRUD para la tabla Huespedes, las funciones son:
        - obtenerHuespedes(): Obtener todos los huéspedes
        - agregarHuesped($nombre, $email, $documento): Agregar un nuevo huésped
        - borrarHuesped($email): Borrar un huésped
        - actualizarHuesped($nombre, $email, $documento): Actualizar un huésped
    */
    private $pdo;

    public function __construct() {
        $this->pdo = (new Conexion())->getPDO();
    }
    public function obtenerHuespedes() {
        $stmt = $this->pdo->query("SELECT nombre, email, documento FROM Huespedes");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function agregarHuesped($nombre, $email, $documento) {
        $stmt = $this->pdo->prepare("INSERT INTO Huespedes (nombre, email, documento) VALUES (?, ?, ?)");
        $stmt->execute([$nombre, $email, $documento]);
    }
    public function borrarHuesped($email) {
        $stmt = $this->pdo->prepare("DELETE FROM Huespedes WHERE email = ?");
        $stmt->execute([$email]);
    }
    public function actualizarHuesped($nombre, $email, $documento) {
        $stmt = $this->pdo->prepare("UPDATE Huespedes SET nombre = ?, email = ?, documento = ? WHERE email = ?");
        $stmt->execute([$nombre, $email, $documento]);
    }
    public function obtenerHuespedPorEmail($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM Huespedes WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }
    
}

?>