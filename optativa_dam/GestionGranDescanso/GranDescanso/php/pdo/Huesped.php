<?php
    $host = "localhost";
    $db = "GranDescanso";
    $user = "root";
    $pass = "";


    $numero = $_POST['numero'] ?? '';
    $tipo = $_POST['tipo'] ?? '';
    $precio = $_POST['precio'] ?? '';

    $nombre = $_POST['nombre'] ?? '';
    $email = $_POST['email'] ?? '';
    $documento = $_POST['documento'] ?? '';
    

    try {
        $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $pdo = new PDO($dsn, $user, $pass, $options);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['add_room'])) {
                $stmt = $pdo->prepare('INSERT INTO habitaciones (numero, tipo, precio_base) VALUES (?, ?, ?)');
                $stmt->execute([$numero, $tipo, $precio]);
                echo "Habitación añadida exitosamente.";
            } elseif (isset($_POST['add_guest'])) {
                $stmt = $pdo->prepare('INSERT INTO huespedes (nombre, email, documento_identidad) VALUES (?, ?, ?)');
                $stmt->execute([$nombre, $email, $documento]);
                echo "Huésped añadido exitosamente.";
            }
        }
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    }
    header("Location: ../index.html?msg=ok");
    exit;
?>