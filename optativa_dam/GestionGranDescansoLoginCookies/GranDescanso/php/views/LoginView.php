<?php
session_start();
require_once 'partials/mode_handler.php'; // ← añade esto

if (isset($_SESSION['user'])) {
    header("Location: MainView.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="../../css/login.css">
</head>
<body class="<?= $modo_actual === 'oscuro' ? 'oscuro' : '' ?>">
  <div class="login-container">
    <h2>Iniciar Sesión</h2>

    <?php if (!empty($_SESSION['error'])): ?>
      <p class="msg-error"><?= htmlspecialchars($_SESSION['error']) ?></p>
      <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    <?php if (!empty($_SESSION['success'])): ?>
      <p class="msg-success"><?= htmlspecialchars($_SESSION['success']) ?></p>
      <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <form action="../controller/LoginController.php" method="post">
      <div class="form-group">
        <label for="username">Usuario:</label>
        <input type="text" id="username" name="username" required>
      </div>
      <div class="form-group">
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
      </div>
      <button type="submit" class="btn">Ingresar</button>
    </form>

    <p class="link">
      ¿No tienes cuenta? <a href="RegisterView.php">Crear cuenta</a>
    </p>
    <p>
      <br>Credenciales de prueba:<br>
      Admin - <strong>admin@admin</strong> / <strong>admin</strong><br>
      Usuario - <strong>user@user</strong> / <strong>user</strong>
    </p>

    <!-- Selector de modo -->
  <div class="modo-toggle">
    <a href="?modo=<?= $modo_actual === 'claro' ? 'oscuro' : 'claro' ?>" class="btn-modo">
      <?= $modo_actual === 'claro' ? '🌙 Modo Oscuro' : '☀️ Modo Claro' ?>
    </a>
  </div>
</body>
</html>

