<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - ArtGram</title>
    <link href="/css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Grand+Hotel&display=swap" rel="stylesheet">
</head>

<body>
    <div class="auth-container">
        <div class="auth-box">
            <h1 class="auth-title">ArtGram</h1>

            <?php if (!empty($error)): ?>
                <div class="error-msg"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" action="/login" class="auth-form">
                <input type="text" name="username" class="auth-input" placeholder="Teléfono, usuario o correo electrónico" required>
                <input type="password" name="password" class="auth-input" placeholder="Contraseña" required>
                <button type="submit" class="auth-btn">Iniciar sesión</button>
            </form>
        </div>

        <div class="auth-link-box">
            ¿No tienes una cuenta? <a href="/register">Regístrate</a>
        </div>

        <div style="margin-top:20px; font-size:12px; color:#8e8e8e;">
            <p>Admin: admin / admin123</p>
            <p>User: demo / demo123</p>
        </div>
    </div>
</body>

</html>