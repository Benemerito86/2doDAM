<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Perfil - ArtGram</title>
    <link href="/css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Grand+Hotel&display=swap" rel="stylesheet">
</head>

<body>
    <header class="header">
        <div class="header-content">
            <a href="/" class="logo">ArtGram</a>
            <div class="nav-actions">
                <a href="/post/create" class="nav-btn" title="Nuevo Post">➕</a>
                <a href="/profile/<?= htmlspecialchars($_SESSION['username']) ?>" class="nav-btn" title="Perfil">
                    <img src="<?= htmlspecialchars($_SESSION['avatar'] ?? '') ?>" style="width:24px;height:24px;border-radius:50%;display:block;">
                </a>
            </div>
        </div>
    </header>

    <div class="profile-container">
        <header class="profile-header">
            <div class="profile-avatar-container">
                <img src="<?= htmlspecialchars($user['avatar']) ?>" class="profile-avatar" alt="Avatar">
            </div>
            <div class="profile-info">
                <div class="profile-username">
                    <?= htmlspecialchars($user['username']) ?>
                    <?php if ($user['username'] === $_SESSION['username']): ?>
                        <a href="/logout" style="font-size:14px; font-weight:600; margin-left:20px; color:#262626; border:1px solid #dbdbdb; padding:5px 9px; border-radius:4px; text-decoration:none;">Cerrar sesión</a>
                    <?php endif; ?>
                </div>

                <div class="profile-stats">
                    <span class="stat-item"><strong><?= count($posts) ?></strong> publicaciones</span>
                </div>

                <div class="profile-name"><?= htmlspecialchars($user['name']) ?></div>
                <div><?= htmlspecialchars($user['role'] === 'admin' ? 'Administrador' : '') ?></div>
            </div>
        </header>

        <div class="posts-grid">
            <?php foreach ($posts as $post): ?>
                <div class="grid-item" onclick="window.location.href='#post-<?= $post['id'] ?>'">
                    <img src="/<?= htmlspecialchars($post['image']) ?>" class="grid-img">
                    <?php if (($post['user_id'] == $_SESSION['user_id']) || ($_SESSION['role'] === 'admin')): ?>
                        <!-- Optional delete button on hover could go here, but let's keep it simple -->
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="/js/main.js"></script>
</body>

</html>