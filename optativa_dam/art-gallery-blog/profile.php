<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$usersFile = 'data/users.json';
$users = file_exists($usersFile) ? json_decode(file_get_contents($usersFile), true) : [];

// Check if viewing another profile or self
$viewUsername = $_GET['user'] ?? $_SESSION['username'];
$viewUser = null;

foreach ($users as $u) {
    if ($u['username'] === $viewUsername) {
        $viewUser = $u;
        break;
    }
}

if (!$viewUser) {
    echo "Usuario no encontrado";
    exit;
}

$isOwnProfile = ($viewUser['id'] === $_SESSION['user_id']);
$postsFile = 'data/posts.json';
$allPosts = file_exists($postsFile) ? json_decode(file_get_contents($postsFile), true) : [];

// Filter posts by this user
$userPosts = array_filter($allPosts, function ($p) use ($viewUser) {
    return $p['user_id'] === $viewUser['id'];
});

// Sort by recent
usort($userPosts, function ($a, $b) {
    return strtotime($b['created_at']) - strtotime($a['created_at']);
});
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($viewUser['name']) ?> (@<?= htmlspecialchars($viewUser['username']) ?>) - ArtGram</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Reuse core styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --bg-dark: #000000;
            --bg-secondary: #121212;
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

        /* Header (Same as Index) */
        .header {
            background: var(--bg-secondary);
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-content {
            max-width: 935px;
            margin: 0 auto;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            text-decoration: none;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-links a {
            color: var(--text-primary);
            text-decoration: none;
            margin-left: 1rem;
            font-weight: 500;
        }

        /* Profile Header */
        .profile-header {
            max-width: 935px;
            margin: 0 auto;
            padding: 3rem 2rem;
            display: flex;
            gap: 4rem;
            align-items: flex-start;
            border-bottom: 1px solid var(--border-color);
        }

        .profile-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 3px solid var(--accent);
            padding: 3px;
            background-clip: content-box;
        }

        .profile-info {
            flex: 1;
        }

        .profile-name {
            font-size: 1.8rem;
            font-weight: 300;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .profile-stats {
            display: flex;
            gap: 2rem;
            margin-bottom: 1.5rem;
            font-size: 1rem;
        }

        .profile-stats strong {
            font-weight: 600;
        }

        .profile-bio {
            font-size: 1rem;
            line-height: 1.5;
        }

        .profile-realname {
            font-weight: 600;
            display: block;
            margin-bottom: 0.3rem;
        }

        /* Grid */
        .gallery-grid {
            max-width: 935px;
            margin: 0 auto;
            padding: 2rem;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
        }

        .grid-item {
            position: relative;
            aspect-ratio: 1;
            cursor: pointer;
            overflow: hidden;
            background: var(--bg-secondary);
        }

        .grid-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .grid-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            opacity: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 1.5rem;
            color: white;
            font-weight: 600;
            transition: opacity 0.2s ease;
        }

        .grid-item:hover .grid-overlay {
            opacity: 1;
        }

        .delete-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(255, 59, 48, 0.8);
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            z-index: 10;
        }

        .delete-btn:hover {
            background: #ff3b30;
        }

        @media (max-width: 768px) {
            .profile-header {
                flex-direction: column;
                gap: 2rem;
                padding: 2rem;
                text-align: center;
            }

            .profile-avatar {
                margin: 0 auto;
                width: 100px;
                height: 100px;
            }

            .profile-info {
                width: 100%;
            }

            .profile-name {
                justify-content: center;
            }

            .profile-stats {
                justify-content: center;
            }

            .gallery-grid {
                gap: 0.5rem;
                padding: 0.5rem;
            }
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="header-content">
            <a href="index.php" class="logo">🎨 ArtGram</a>
            <div class="nav-links">
                <a href="index.php">Inicio</a>
                <a href="logout.php">Salir</a>
                <?php if (!$isOwnProfile): ?>
                    <a href="profile.php?user=<?= htmlspecialchars($_SESSION['username']) ?>">Mi Perfil</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <main>
        <div class="profile-header">
            <img src="<?= htmlspecialchars($viewUser['avatar']) ?>" alt="" class="profile-avatar">
            <div class="profile-info">
                <h1 class="profile-name">
                    <?= htmlspecialchars($viewUser['username']) ?>
                    <?php if ($isOwnProfile): ?>
                        <span style="font-size: 0.9rem; border:1px solid #363636; padding: 5px 10px; border-radius: 4px;">Editar perfil</span>
                    <?php endif; ?>
                </h1>

                <div class="profile-stats">
                    <span><strong><?= count($userPosts) ?></strong> publicaciones</span>
                    <span><strong><?= rand(100, 5000) ?></strong> seguidores</span>
                    <span><strong><?= rand(50, 500) ?></strong> seguidos</span>
                </div>

                <div class="profile-bio">
                    <span class="profile-realname"><?= htmlspecialchars($viewUser['name']) ?></span>
                    <?= htmlspecialchars($viewUser['bio']) ?>
                </div>
            </div>
        </div>

        <div class="gallery-grid">
            <?php foreach ($userPosts as $post): ?>
                <div class="grid-item" id="post-<?= $post['id'] ?>">
                    <img src="<?= htmlspecialchars($post['image']) ?>" alt="">

                    <?php if ($isOwnProfile): ?>
                        <button class="delete-btn" onclick="deletePost('<?= $post['id'] ?>')">🗑️</button>
                    <?php endif; ?>

                    <div class="grid-overlay">
                        <span>❤️ <?= is_array($post['likes']) ? count($post['likes']) : 0 ?></span>
                        <span>💬 <?= isset($post['comments']) ? count($post['comments']) : 0 ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <script>
        async function deletePost(postId) {
            if (!confirm('¿Seguro que quieres borrar este post?')) return;

            try {
                const response = await fetch('actions/delete_post.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        post_id: postId
                    })
                });
                const data = await response.json();

                if (data.success) {
                    document.getElementById('post-' + postId).remove();
                } else {
                    alert('Error: ' + data.message);
                }
            } catch (e) {
                alert('Error de conexión');
            }
        }
    </script>
</body>

</html>