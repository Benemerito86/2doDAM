<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de tareas</title>
</head>
<body>
    <h1>Lista de tareas</h1>
    <form method="POST">
        <label for="tarea">Tarea:</label>
        <input type="text" id="tarea" name="tarea" required>
        <input type="submit" value="Agregar tarea">
        <?php 
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $tarea = trim($_POST["tarea"]);

                if (!empty($tarea)) {
                    $archivo = "tareas.xml";

                    if (!file_exists($archivo)) {
                        $xml = new SimpleXMLElement("<tareas></tareas>");
                    } else {
                        $xml = simplexml_load_file($archivo);
                    }

                    $nuevaTarea = $xml->addChild("tarea", htmlspecialchars($tarea));
                    $nuevaTarea->addAttribute("fecha", date("Y-m-d H:i:s"));

                    $xml->asXML($archivo);

                    echo "<p>Tarea agregada con éxito</p>";
                } else {
                    echo "<p>La tarea no puede estar vacía</p>";
                }
                echo "<h2>Tareas guardadas:</h2><ul>";
                foreach ($xml->tarea as $t) {
                    echo "<li>" . $t . " <em>(" . $t['fecha'] . ")</em></li>";
                }
                echo "</ul>";
            }
        
        ?>
    </form>
    
</body>
</html>
