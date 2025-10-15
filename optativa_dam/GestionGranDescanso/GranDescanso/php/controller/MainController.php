<?php
require_once '../pdo/Habitacion.php';

class MainController {
    private $habitacion;

    public function __construct() {
        $this->habitacion = new Habitacion();
    }

    // Maneja las solicitudes POST
    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_room'])) {
            $this->habitacion->agregar($_POST['numero'], $_POST['tipo'], $_POST['precio']);
            header("Location: ../views/MainView.php");
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['del_room'])) {
            $this->habitacion->borrar($_POST['numero']);
            header("Location: ../views/MainView.php");
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upd_room'])) {
            $this->habitacion->actualizar($_POST['numero'], $_POST['tipo'], $_POST['precio']);
            header("Location: ../views/MainView.php");
            exit;
        }
    }

    // Devuelve datos para la vista
    public function getData() {
        return ['habitaciones' => $this->habitacion->obtenerTodas()];
    }
}

$controller = new MainController();
$controller->handleRequest();
?>