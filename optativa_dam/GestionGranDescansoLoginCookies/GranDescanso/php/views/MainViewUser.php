<?php
session_start();

// Verificar login
if (!isset($_SESSION['user'])) {
    header("Location: LoginView.php");
    exit;
}

// Manejar cierre de sesión
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    $_SESSION = [];
    session_destroy();
    header("Location: LoginView.php");
    exit;
}

// Manejar cambio de modo
if (isset($_GET['modo'])) {
    $modo = $_GET['modo'] === 'oscuro' ? 'oscuro' : 'claro';
    setcookie('modo_tema', $modo, time() + 2592000, "/");
    header("Location: " . strtok($_SERVER['REQUEST_URI'], '?'));
    exit;
}
$modo_actual = $_COOKIE['modo_tema'] ?? 'claro';

// === Cargar datos ===
require_once '../model/Conexion.php';
require_once '../pdo/Habitacion.php';
$habitacionObj = new Habitacion();
$habitaciones = $habitacionObj->obtenerHabitaciones();

require_once '../pdo/Huesped.php';
$huespedObj = new Huesped();
// Solo cargar el huésped actual (si el email del usuario está en Huespedes)
// Asumimos que el username en 'Usuario' coincide con el email en 'Huespedes'
$huespedActual = $huespedObj->obtenerHuespedPorEmail($_SESSION['user']);
$huespedes = $huespedActual ? [$huespedActual] : [];

require_once '../pdo/Reservas.php';
$reservaObj = new Reservas();
// Solo reservas del usuario actual
$reservasUsuario = $reservaObj->obtenerReservasPorHuesped($_SESSION['user']);

require_once '../pdo/Mantenimiento.php';
$mantenimientoObj = new Mantenimiento();
$mantenimientos = $mantenimientoObj->obtenerMantenimientos();
?>

<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>SGH — Panel de Usuario</title>
  <link href="../../css/styles.css" rel="stylesheet" />
</head>
<body class="<?= $modo_actual === 'oscuro' ? 'oscuro' : '' ?>">
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h1>SGH — Panel de Usuario</h1>
    <div style="display: flex; gap: 10px;">
      <!-- Toggle modo -->
      <a href="?modo=<?= $modo_actual === 'claro' ? 'oscuro' : 'claro' ?>" class="btn" 
         style="padding: 6px 12px; font-size: 0.85rem; background: #64748b;">
        <?= $modo_actual === 'claro' ? '🌙 Oscuro' : '☀️ Claro' ?>
      </a>
      <!-- Cerrar sesión -->
      <form method="post" style="display: inline;">
        <button type="submit" name="logout" class="btn" 
                style="background-color: #ef4444; padding: 6px 12px; font-size: 0.85rem;">
          Cerrar Sesión
        </button>
      </form>
    </div>
  </div>

  <!-- Habitaciones (solo lectura) -->
  <div class="box">
    <h2>Habitaciones Disponibles</h2>
    <div class="table-column" style="border: none; box-shadow: none; background: transparent;">
      <table>
        <thead>
          <tr><th>Número</th><th>Tipo</th><th>Precio/noche</th><th>Estado</th></tr>
        </thead>
        <tbody>
          <?php foreach ($habitaciones as $hab): ?>
            <tr>
              <td><?= htmlspecialchars($hab['numero']) ?></td>
              <td><?= htmlspecialchars($hab['tipo']) ?></td>
              <td><?= htmlspecialchars($hab['precio_base']) ?> €</td>
              <td><?= htmlspecialchars($hab['estado_limpieza']) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Mi perfil (solo el usuario actual) -->
  <?php if (!empty($huespedes)): ?>
  <div class="box">
    <h2>Mi Perfil</h2>
    <div class="table-column" style="border: none; box-shadow: none; background: transparent;">
      <table>
        <thead><tr><th>Nombre</th><th>Email</th><th>Documento</th></tr></thead>
        <tbody>
          <?php foreach ($huespedes as $huesped): ?>
            <tr>
              <td><?= htmlspecialchars($huesped['nombre']) ?></td>
              <td><?= htmlspecialchars($huesped['email']) ?></td>
              <td><?= htmlspecialchars($huesped['documento']) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
  <?php endif; ?>

  <!-- Mis reservas -->
  <div class="box">
    <h2>Mis Reservas</h2>
    <div class="table-column" style="border: none; box-shadow: none; background: transparent;">
      <table>
        <thead>
          <tr><th>Id</th><th>Habitación</th><th>Desde</th><th>Hasta</th><th>Precio Total</th><th>Estado</th></tr>
        </thead>
        <tbody>
          <?php if (!empty($reservasUsuario)): ?>
            <?php foreach ($reservasUsuario as $reserva): ?>
              <tr>
                <td><?= htmlspecialchars($reserva['id']) ?></td>
                <td><?= htmlspecialchars($reserva['habitacion_numero']) ?></td>
                <td><?= htmlspecialchars($reserva['inicio']) ?></td>
                <td><?= htmlspecialchars($reserva['fin']) ?></td>
                <td><?= htmlspecialchars($reserva['precio_total']) ?> €</td>
                <td><?= htmlspecialchars($reserva['estado']) ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr><td colspan="6" style="text-align: center; padding: 12px;">No tienes reservas.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Mantenimientos programados -->
  <div class="box">
    <h2>Mantenimientos Programados</h2>
    <div class="table-column" style="border: none; box-shadow: none; background: transparent;">
      <table>
        <thead><tr><th>Habitación</th><th>Desde</th><th>Hasta</th><th>Descripción</th></tr></thead>
        <tbody>
          <?php if (!empty($mantenimientos)): ?>
            <?php foreach ($mantenimientos as $mant): ?>
              <tr>
                <td><?= htmlspecialchars($mant['habitacion_numero']) ?></td>
                <td><?= htmlspecialchars($mant['inicio']) ?></td>
                <td><?= htmlspecialchars($mant['fin']) ?></td>
                <td><?= htmlspecialchars($mant['descripcion']) ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr><td colspan="4" style="text-align: center; padding: 12px;">No hay mantenimientos programados.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>