<?php
require_once '../model/Conexion.php';

class Reservas {# Clase para manejar las reservas
    /* En esta clase se implementan los métodos CRUD para la tabla reservas, las funciones son:
        - obtenerReservas(): Obtener todas las reservas
        - agregar($huesped_email, $habitacion_numero, $inicio, $fin, $precio_total, $estado): Agregar una nueva reserva
        - borrar($id): Borrar una reserva
        - actualizar($id, $huesped_email, $habitacion_numero, $inicio, $fin, $precio_total, $estado): Actualizar una reserva
        - habitacionDisponible($habitacion_numero, $inicio, $fin, $excludeId = null): Verificar si una habitación está disponible en un rango de fechas
    */
    private $pdo;

    public function __construct() {
        $this->pdo = (new Conexion())->getPDO();
    }

    public function obtenerReservas() {
        $stmt = $this->pdo->query("SELECT id, huesped_email, habitacion_numero, inicio, fin, precio_total, estado FROM reservas");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function agregar($huesped_email, $habitacion_numero, $inicio, $fin, $precio_total, $estado) {
        if ($estado != 'Cancelada' && !$this->habitacionDisponible($habitacion_numero, $inicio, $fin)) {
            throw new Exception("La habitación ya tiene una reserva confirmada en esas fechas.");
        }

        $stmt = $this->pdo->prepare("INSERT INTO reservas (huesped_email, habitacion_numero, inicio, fin, precio_total, estado) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$huesped_email, $habitacion_numero, $inicio, $fin, $precio_total, $estado]);
    }

    public function actualizar($id, $huesped_email, $habitacion_numero, $inicio, $fin, $precio_total, $estado) {
        if ($estado != 'Cancelada' && !$this->habitacionDisponible($habitacion_numero, $inicio, $fin, $id)) {
            throw new Exception("La habitación ya tiene una reserva confirmada en esas fechas.");
        }

        $stmt = $this->pdo->prepare("UPDATE reservas SET huesped_email = ?, habitacion_numero = ?, inicio = ?, fin = ?, precio_total = ?, estado = ? WHERE id = ?");
        $stmt->execute([$huesped_email, $habitacion_numero, $inicio, $fin, $precio_total, $estado, $id]);
    }

    public function borrar($id) {
        $stmt = $this->pdo->prepare("DELETE FROM reservas WHERE id = ?");
        $stmt->execute([$id]);
    }
    public function obtenerReservasPorHuesped($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM Reservas WHERE huesped_email = ? ORDER BY inicio DESC");
        $stmt->execute([$email]);
        return $stmt->fetchAll();
    }

    public function habitacionDisponible($habitacion_numero, $inicio, $fin, $excludeId = null) {
        $sql = "SELECT COUNT(*) FROM reservas 
                WHERE habitacion_numero = ? 
                AND estado = 'Confirmada' 
                OR estado = 'Pendiente'
                AND inicio <= ? 
                AND fin >= ?";
        $params = [$habitacion_numero, $fin, $inicio];

        if ($excludeId) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() == 0; // true si no hay solapamiento
    }

}

?>