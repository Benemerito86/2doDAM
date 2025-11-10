<?php # Controlador principal para manejar las solicitudes y coordinar entre el modelo y la vista
require_once __DIR__ . '/../pdo/Habitacion.php';
require_once __DIR__ . '/../pdo/Huesped.php';
require_once __DIR__ . '/../pdo/Reservas.php';
require_once __DIR__ . '/../pdo/Mantenimiento.php';


class MainController {
    private $habitacion;
    private $huesped;
    private $reserva;
    private $mantenimiento;


    public function __construct() {
        $this->habitacion = new Habitacion();
        $this->huesped = new Huesped();
        $this->reserva = new Reservas();
        $this->mantenimiento = new Mantenimiento();
    }

    // Maneja las solicitudes POST
    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_room'])) {
            $this->habitacion->agregar($_POST['numero'], $_POST['tipo'], $_POST['precio'], $_POST['estado_limpieza']);
            header("Location: ../views/MainView.php");
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['del_room'])) {
            $this->habitacion->borrar($_POST['numero']);
            header("Location: ../views/MainView.php");
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upd_room'])) {
            $this->habitacion->actualizar($_POST['numero'], $_POST['tipo'], $_POST['precio'], $_POST['estado_limpieza']);
            header("Location: ../views/MainView.php");
            exit;
        }
        // Manejo similar para huéspedes
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_guest'])) {
            $this->huesped->agregarHuesped($_POST['nombre'], $_POST['email'], $_POST['documento']);
            header("Location: ../views/MainView.php");
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['del_guest'])) {
            $this->huesped->borrarHuesped($_POST['email']);
            header("Location: ../views/MainView.php");
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upd_guest'])) {
                $this->huesped->actualizarHuesped($_POST['nombre'], $_POST['email'], $_POST['telefono']);
                header("Location: ../views/MainView.php");
                exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_reservation'])) {
            $this->reserva->agregar($_POST['huesped_email'], $_POST['habitacion_numero'], $_POST['inicio'], $_POST['fin'], $_POST['precio_total'], $_POST['estado']);
            header("Location: ../views/MainView.php");
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['del_reservation'])) {
            $this->reserva->borrar($_POST['id']);
            header("Location: ../views/MainView.php");
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upd_reservation'])) {
            $this->reserva->actualizar($_POST['id'], $_POST['huesped_email'], $_POST['habitacion_numero'], $_POST['inicio'], $_POST['fin'], $_POST['precio_total'], $_POST['estado']);
            header("Location: ../views/MainView.php");
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_maintenance'])) {
            $this->mantenimiento->agregar($_POST['habitacion_numero'], $_POST['inicio'], $_POST['fin'], $_POST['descripcion']);
            header("Location: ../views/MainView.php");
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['del_maintenance'])) {
            $this->mantenimiento->borrar($_POST['id']);
            header("Location: ../views/MainView.php");
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upd_maintenance'])) {
            $this->mantenimiento->actualizar($_POST['id'], $_POST['habitacion_numero'], $_POST['inicio'], $_POST['fin'], $_POST['descripcion']);
            header("Location: ../views/MainView.php");
            exit;
        }
        

        
    }

    public function getData() {
        return ['habitaciones' => $this->habitacion->obtenerHabitaciones()];
    }
    public function getGuestData() {
        return ['huespedes' => $this->huesped->obtenerHuespedes()];
    }
    public function getReservationData() {
        return ['reservas' => $this->reserva->obtenerReservas()];
    }
    public function getMantenimientoData() {
        return ['mantenimientos' => $this->mantenimiento->obtenerMantenimientos()];
    }

}

$controller = new MainController();
$controller->handleRequest();
?>