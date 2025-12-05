<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse - ArtGram</title>
    <link href="/css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Grand+Hotel&display=swap" rel="stylesheet">
</head>

<body>
    <div class="auth-container">
        <div class="auth-box">
            <h1 class="auth-title">ArtGram</h1>
            <p style="color:#8e8e8e; font-weight:600; font-size:17px; margin-bottom:20px;">
                Regístrate para ver fotos y vídeos de tus amigos.
            </p>

            <?php if (!empty($error)): ?>
                <div class="error-msg"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" action="/register" class="auth-form">
                <input type="text" name="name" class="auth-input" placeholder="Nombre completo" required>
                <input type="text" name="username" class="auth-input" placeholder="Nombre de usuario" required>
                <input type="password" name="password" class="auth-input" placeholder="Contraseña" required>
                <input type="password" name="confirm_password" class="auth-input" placeholder="Confirmar contraseña" required>

                <p style="font-size:12px; color:#8e8e8e; margin:10px 0;">
                    Al registrarte, aceptas nuestras Condiciones.
                </p>

                <button type="submit" class="auth-btn">Registrarte</button>
            </form>
        </div>

        <div class="auth-link-box">
            ¿Tienes una cuenta? <a href="/login">Entrar</a>
        </div>
    </div>
</body>

</html>