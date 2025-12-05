<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $caption = trim($_POST['caption'] ?? '');
    $imageUrl = trim($_POST['image_url'] ?? '');

    if (empty($caption)) {
        $error = 'La descripción es obligatoria';
    } elseif (empty($imageUrl)) {
        $error = 'La URL de la imagen es obligatoria';
    } else {
        $postsFile = 'data/posts.json';
        $posts = file_exists($postsFile) ? json_decode(file_get_contents($postsFile), true) : [];

        $newPost = [
            'id' => uniqid(),
            'user_id' => $_SESSION['user_id'],
            'image' => $imageUrl,
            'caption' => $caption,
            'likes' => 0,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $posts[] = $newPost;

        if (!is_dir('data')) {
            mkdir('data', 0777, true);
        }

        file_put_contents($postsFile, json_encode($posts, JSON_PRETTY_PRINT));

        header('Location: index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Post - ArtGram</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --bg-dark: #000000;
            --bg-secondary: #121212;
            --bg-card: #1a1a1a;
            --border-color: #363636;
            --text-primary: #ffffff;
            --text-secondary: #a8a8a8;
            --accent: #667eea;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg-dark);
            color: var(--text-primary);
            min-height: 100vh;
        }

        .header {
            background: var(--bg-secondary);
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 2rem;
        }

        .header-content {
            max-width: 935px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea, #764ba2, #f093fb);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .btn-back {
            color: var(--text-secondary);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .btn-back:hover {
            color: var(--text-primary);
        }

        .container {
            max-width: 600px;
            margin: 3rem auto;
            padding: 0 1rem;
        }

        .create-form {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 2rem;
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h1 {
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            font-size: 0.95rem;
        }

        input,
        textarea {
            width: 100%;
            padding: 0.9rem 1rem;
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid var(--border-color);
            border-radius: 10px;
            color: var(--text-primary);
            font-size: 1rem;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s ease;
        }

        textarea {
            resize: vertical;
            min-height: 120px;
        }

        input:focus,
        textarea:focus {
            outline: none;
            border-color: var(--accent);
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .image-preview {
            margin-top: 1rem;
            border-radius: 10px;
            overflow: hidden;
            display: none;
        }

        .image-preview img {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
        }

        .btn-submit {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            border-radius: 10px;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }

        .error {
            background: rgba(255, 59, 48, 0.1);
            border: 1px solid rgba(255, 59, 48, 0.3);
            color: #ff3b30;
            padding: 0.8rem;
            border-radius: 10px;
            margin-bottom: 1rem;
            text-align: center;
        }

        .help-text {
            color: var(--text-secondary);
            font-size: 0.85rem;
            margin-top: 0.5rem;
        }

        .suggestions {
            background: rgba(102, 126, 234, 0.1);
            border: 1px solid rgba(102, 126, 234, 0.3);
            border-radius: 10px;
            padding: 1rem;
            margin-top: 1rem;
        }

        .suggestions h3 {
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
            color: var(--accent);
        }

        .suggestions ul {
            list-style: none;
            font-size: 0.85rem;
            color: var(--text-secondary);
        }

        .suggestions li {
            padding: 0.3rem 0;
            cursor: pointer;
            transition: color 0.2s ease;
        }

        .suggestions li:hover {
            color: var(--text-primary);
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="header-content">
            <div class="logo">🎨 ArtGram</div>
            <a href="index.php" class="btn-back">← Volver al feed</a>
        </div>
    </header>

    <div class="container">
        <div class="create-form">
            <h1>Crear Nueva Publicación</h1>

            <?php if ($error): ?>
                <div class="error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" id="createPostForm">
                <div class="form-group">
                    <label for="image_url">URL de la imagen</label>
                    <input type="url" id="image_url" name="image_url" required
                        placeholder="https://ejemplo.com/imagen.jpg"
                        value="<?= htmlspecialchars($_POST['image_url'] ?? '') ?>">
                    <p class="help-text">Pega la URL de una imagen desde internet</p>

                    <div class="suggestions">
                        <h3>💡 Sugerencias de imágenes:</h3>
                        <ul>
                            <li onclick="setImage('https://images.unsplash.com/photo-1579783902614-a3fb3927b6a5?w=800')">🎨 Arte abstracto colorido</li>
                            <li onclick="setImage('https://images.unsplash.com/photo-1547891654-e66ed7ebb968?w=800')">🖼️ Galería de arte</li>
                            <li onclick="setImage('https://images.unsplash.com/photo-1460661419201-fd4cecdf8a8b?w=800')">🌅 Paisaje artístico</li>
                            <li onclick="setImage('https://images.unsplash.com/photo-1513364776144-60967b0f800f?w=800')">🌸 Flores artísticas</li>
                            <li onclick="setImage('https://images.unsplash.com/photo-1549887534-1541e9326642?w=800')">🎭 Arte moderno</li>
                        </ul>
                    </div>

                    <div class="image-preview" id="imagePreview">
                        <img src="" alt="Preview" id="previewImg">
                    </div>
                </div>

                <div class="form-group">
                    <label for="caption">Descripción</label>
                    <textarea id="caption" name="caption" required
                        placeholder="Escribe algo sobre tu obra de arte..."><?= htmlspecialchars($_POST['caption'] ?? '') ?></textarea>
                    <p class="help-text">Comparte la historia detrás de tu arte</p>
                </div>

                <button type="submit" class="btn-submit">Publicar</button>
            </form>
        </div>
    </div>

    <script>
        const imageInput = document.getElementById('image_url');
        const imagePreview = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');

        function setImage(url) {
            imageInput.value = url;
            showPreview(url);
        }

        function showPreview(url) {
            previewImg.src = url;
            imagePreview.style.display = 'block';
        }

        imageInput.addEventListener('input', function() {
            if (this.value) {
                showPreview(this.value);
            } else {
                imagePreview.style.display = 'none';
            }
        });

        // Si ya hay una URL, mostrar preview
        if (imageInput.value) {
            showPreview(imageInput.value);
        }
    </script>
</body>

</html>