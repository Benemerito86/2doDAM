<?php

    $numero = $_POST['numero'] ?? '';
    $tipo = $_POST['tipo'] ?? '';
    $precio = $_POST['precio'] ?? '';

    $nombre = $_POST['nombre'] ?? '';
    $email = $_POST['email'] ?? '';
    $documento = $_POST['documento'] ?? '';

    if ($numero && $tipo && $precio) {
        echo "<h2>Habitación añadida:</h2>";
        echo "<p>Número: " . htmlspecialchars($numero) . "</p>";
        echo "<p>Tipo: " . htmlspecialchars($tipo) . "</p>";
        echo "<p>Precio: " . htmlspecialchars($precio) . " €</p>";
    } else {
        echo "<h2>Error: Faltan datos de la habitación.</h2>";
    }
?>