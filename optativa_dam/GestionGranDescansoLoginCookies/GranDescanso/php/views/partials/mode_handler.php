<?php
// views/partials/mode_handler.php

// Manejar cambio de modo (si viene en la URL)
if (isset($_GET['modo'])) {
    $modo = $_GET['modo'] === 'oscuro' ? 'oscuro' : 'claro';
    setcookie('modo_tema', $modo, time() + 2592000, "/"); // 30 días, raíz del sitio
    // Redirigir sin el parámetro ?modo=...
    $uri = strtok($_SERVER['REQUEST_URI'], '?');
    header("Location: $uri");
    exit;
}

// Obtener modo actual
$modo_actual = $_COOKIE['modo_tema'] ?? 'claro';
?>