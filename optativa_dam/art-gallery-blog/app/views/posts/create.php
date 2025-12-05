<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Nuevo Post - ArtGram</title>
    <link href="/css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .container {
            max-width: 600px;
            margin: 2rem auto;
            padding: 1rem;
            color: white;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
        }

        input[type="text"],
        input[type="url"],
        textarea {
            width: 100%;
            padding: 10px;
            background: #222;
            border: 1px solid #444;
            color: white;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #667eea;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="header-content">
            <a href="/" class="logo">ArtGram</a>
            <a href="/" style="color:white; text-decoration:none;">Cancelar</a>
        </div>
    </header>

    <div class="container">
        <h1>Crear nueva publicación</h1>

        <form method="POST" action="/post/create" enctype="multipart/form-data">
            <div class="form-group">
                <label>Opción 1: Subir imagen</label>
                <input type="file" name="image_file" accept="image/*">
            </div>

            <div class="form-group" style="text-align:center;">- O -</div>

            <div class="form-group">
                <label>Opción 2: URL de imagen</label>
                <input type="url" name="image_url" placeholder="https://...">
            </div>

            <div class="form-group">
                <label>Descripción</label>
                <textarea name="caption" rows="4" required placeholder="Escribe algo..."></textarea>
            </div>

            <button type="submit">Publicar</button>
        </form>
    </div>
</body>

</html>