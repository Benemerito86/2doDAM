<?php
session_start();
require_once '../model/Conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Método no permitido');
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    $_SESSION['error'] = 'Usuario y contraseña son obligatorios.';
    header('Location: ../views/LoginView.php');
    exit;
}

try {
    $db = (new Conexion())->getPDO();
    $stmt = $db->prepare("SELECT username, contraseña, tipo FROM Usuario WHERE username = ?");
    $stmt->execute([$username]);
    $usuario = $stmt->fetch();

    // ⚠️ Comparación en texto claro (NO recomendado, pero compatible con tu DB actual)
    if ($usuario && $password === $usuario['contraseña']) {
        $_SESSION['user'] = $usuario['username'];
        $_SESSION['tipo'] = $usuario['tipo'];
        if ($usuario['tipo'] === 'admin') {
            header('Location: ../views/MainView.php');
        } else {
            header('Location: ../views/MainViewUser.php');
        }
        exit;
    } else {
        $_SESSION['error'] = 'Credenciales incorrectas.';
        header('Location: ../views/LoginView.php');
        exit;
    }

} catch (Exception $e) {
    error_log("Error en login: " . $e->getMessage());
    $_SESSION['error'] = 'Error interno. Inténtalo más tarde.';
    header('Location: ../views/LoginView.php');
    exit;
}
?>