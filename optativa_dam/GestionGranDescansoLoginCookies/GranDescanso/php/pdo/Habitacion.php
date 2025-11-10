<?php
require_once '../model/Conexion.php'; # Incluir la clase de conexión a la base de datos

class Habitacion {# Clase para manejar las habitaciones
    /* En esta clase se implementan los métodos CRUD para la tabla Habitaciones, las funciones son:
        - obtenerHabitaciones(): Obtener todas las habitaciones
        - agregar($numero, $tipo, $precio, $estado_limpieza): Agregar una nueva habitación
        - borrar($numero): Borrar una habitación
        - actualizar($numero, $tipo, $precio, $estado_limpieza): Actualizar una habitación
    */
    private $pdo;

    public function __construct() {
        $this->pdo = (new Conexion())->getPDO();
    }

    public function obtenerHabitaciones() {# Obtener todas las habitaciones
        $stmt = $this->pdo->query("SELECT numero, tipo, precio_base, estado_limpieza FROM habitaciones");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function agregar($numero, $tipo, $precio, $estado_limpieza) {# Agregar una nueva habitación
        $stmt = $this->pdo->prepare("INSERT INTO habitaciones (numero, tipo, precio_base, estado_limpieza) VALUES (?, ?, ?, ?)");
        $stmt->execute([$numero, $tipo, $precio, $estado_limpieza]);
    }
    public function borrar($numero) {# Borrar una habitación
        $stmt = $this->pdo->prepare("DELETE FROM habitaciones WHERE numero = ?");
        $stmt->execute([$numero]);
    }
    public function actualizar($numero, $tipo, $precio, $estado_limpieza) {# Actualizar una habitación
        $stmt = $this->pdo->prepare("UPDATE habitaciones SET tipo = ?, precio_base = ?, estado_limpieza = ? WHERE numero = ?");
        $stmt->execute([$tipo, $precio, $numero, $estado_limpieza]);
    }
}

?>