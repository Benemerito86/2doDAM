<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ArtGram</title>
    <link href="/css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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

    <main class="feed">
        <?php foreach ($posts as $post): ?>
            <article class="post" id="post-<?= $post['id'] ?>">
                <div class="post-header">
                    <a href="/profile/<?= htmlspecialchars($post['username']) ?>" class="user-link">
                        <img src="<?= htmlspecialchars($post['user_avatar']) ?>" class="avatar" alt="">
                        <span class="username"><?= htmlspecialchars($post['username']) ?></span>
                    </a>

                    <?php if (($post['user_id'] == $_SESSION['user_id']) || ($_SESSION['role'] === 'admin')): ?>
                        <button class="delete-btn" onclick="deletePost('<?= $post['id'] ?>')">×</button>
                    <?php endif; ?>
                </div>

                <img src="<?= htmlspecialchars($post['image']) ?>" class="post-img" alt="Post">

                <div class="post-actions">
                    <button class="action-btn <?= $post['is_liked'] ? 'liked' : '' ?>" onclick="toggleLike('<?= $post['id'] ?>', this)">
                        <?= $post['is_liked'] ? '❤️' : '🤍' ?>
                    </button>
                    <button class="action-btn" onclick="focusComment('<?= $post['id'] ?>')">💬</button>
                    <button class="action-btn">📤</button>
                </div>

                <div class="likes-count" id="likes-count-<?= $post['id'] ?>">
                    <?= $post['likes_count'] ?> Me gusta
                </div>

                <div class="caption">
                    <span class="username"><?= htmlspecialchars($post['username']) ?></span>
                    <?= htmlspecialchars($post['caption']) ?>
                </div>

                <div class="comments-list" id="comments-<?= $post['id'] ?>">
                    <?php foreach ($post['comments'] as $comment): ?>
                        <div class="comment">
                            <span class="comment-user"><?= htmlspecialchars($comment['username']) ?></span>
                            <?= htmlspecialchars($comment['text']) ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <time class="time"><?= date('d F', strtotime($post['created_at'])) ?></time>

                <form class="comment-form" onsubmit="postComment(event, '<?= $post['id'] ?>')">
                    <input type="text" class="comment-input" placeholder="Añade un comentario..." id="input-<?= $post['id'] ?>">
                    <button type="submit" class="comment-submit">Publicar</button>
                </form>
            </article>
        <?php endforeach; ?>
    </main>

    <script src="/js/main.js"></script>
</body>

</html>