<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$postsFile = 'data/posts.json';
$usersFile = 'data/users.json';
$posts = file_exists($postsFile) ? json_decode(file_get_contents($postsFile), true) : [];
$users = file_exists($usersFile) ? json_decode(file_get_contents($usersFile), true) : [];

// Check current user role
$currentUserRole = 'user';
foreach ($users as $u) {
    if ($u['id'] === $_SESSION['user_id']) {
        if (isset($u['role'])) $currentUserRole = $u['role'];
        break;
    }
}

// Function to find user
function getUserById($id, $users)
{
    foreach ($users as $u) {
        if ($u['id'] === $id) return $u;
    }
    return null;
}

usort($posts, function ($a, $b) {
    return strtotime($b['created_at']) - strtotime($a['created_at']);
});
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ArtGram - Feed</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --bg-dark: #000000;
            --bg-secondary: #0a0a0a;
            --bg-card: #000;
            --border-color: #262626;
            --text-primary: #f5f5f5;
            --text-secondary: #a8a8a8;
            --accent: #667eea;
            --red: #ed4956;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg-dark);
            color: var(--text-primary);
            padding-bottom: 50px;
        }

        /* Header */
        .header {
            background: var(--bg-dark);
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-content {
            max-width: 935px;
            margin: 0 auto;
            padding: 0.7rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea, #f093fb);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .nav-btn {
            text-decoration: none;
            color: var(--text-primary);
            font-size: 1.4rem;
        }

        /* Feed */
        .feed {
            max-width: 470px;
            margin: 2rem auto;
        }

        .post {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }

        .post-header {
            padding: 10px 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .user-link {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: inherit;
        }

        .avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid var(--border-color);
        }

        .username {
            font-weight: 600;
            font-size: 0.9rem;
        }

        .delete-btn {
            background: none;
            border: none;
            font-size: 1.2rem;
            cursor: pointer;
            color: var(--text-secondary);
        }

        .delete-btn:hover {
            color: var(--red);
        }

        .post-img {
            width: 100%;
            display: block;
            object-fit: cover;
            max-height: 585px;
        }

        .post-actions {
            padding: 10px 15px 5px;
            display: flex;
            gap: 1rem;
            font-size: 1.5rem;
        }

        .action-btn {
            background: none;
            border: none;
            color: var(--text-primary);
            cursor: pointer;
            font-size: inherit;
            transition: transform 0.1s;
        }

        .action-btn:active {
            transform: scale(0.9);
        }

        .action-btn.liked {
            color: var(--red);
        }

        .likes-count {
            padding: 0 15px;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .caption {
            padding: 0 15px;
            margin-bottom: 5px;
            font-size: 0.9rem;
        }

        .time {
            padding: 0 15px;
            font-size: 0.7rem;
            color: var(--text-secondary);
            text-transform: uppercase;
            margin-bottom: 10px;
            display: block;
        }

        /* Comments */
        .comments-list {
            padding: 0 15px;
            max-height: 80px;
            overflow-y: auto;
            margin-bottom: 5px;
        }

        .comment {
            font-size: 0.9rem;
            margin-bottom: 4px;
        }

        .comment-user {
            font-weight: 600;
            margin-right: 5px;
        }

        .comment-form {
            border-top: 1px solid var(--border-color);
            display: flex;
            padding: 10px 15px;
        }

        .comment-input {
            background: none;
            border: none;
            flex: 1;
            color: var(--text-primary);
            font-family: inherit;
            outline: none;
        }

        .comment-submit {
            background: none;
            border: none;
            color: var(--accent);
            font-weight: 600;
            cursor: pointer;
            opacity: 0.5;
            pointer-events: none;
        }

        .comment-input:not(:placeholder-shown)~.comment-submit {
            opacity: 1;
            pointer-events: auto;
        }

        @media (max-width: 500px) {
            .feed {
                margin: 0;
            }

            .post {
                border: none;
                border-bottom: 1px solid var(--border-color);
                border-radius: 0;
            }
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="header-content">
            <a href="index.php" class="logo">ArtGram</a>
            <div class="nav-actions">
                <a href="create-post.php" class="nav-btn" title="Nuevo Post">➕</a>
                <a href="profile.php?user=<?= htmlspecialchars($_SESSION['username']) ?>" class="nav-btn" title="Perfil">👤</a>
            </div>
        </div>
    </header>

    <main class="feed">
        <?php foreach ($posts as $post): ?>
            <?php
            $author = getUserById($post['user_id'], $users);
            if (!$author) continue;

            $isLiked = false;
            $likesCount = 0;
            if (isset($post['likes']) && is_array($post['likes'])) {
                $isLiked = in_array($_SESSION['user_id'], $post['likes']);
                $likesCount = count($post['likes']);
            }

            $canDelete = ($post['user_id'] === $_SESSION['user_id']) || ($currentUserRole === 'admin');
            ?>
            <article class="post" id="post-<?= $post['id'] ?>">
                <div class="post-header">
                    <a href="profile.php?user=<?= htmlspecialchars($author['username']) ?>" class="user-link">
                        <img src="<?= htmlspecialchars($author['avatar']) ?>" class="avatar" alt="">
                        <span class="username"><?= htmlspecialchars($author['username']) ?></span>
                    </a>
                    <?php if ($canDelete): ?>
                        <button class="delete-btn" onclick="deletePost('<?= $post['id'] ?>')">×</button>
                    <?php endif; ?>
                </div>

                <img src="<?= htmlspecialchars($post['image']) ?>" class="post-img" alt="Post">

                <div class="post-actions">
                    <button class="action-btn <?= $isLiked ? 'liked' : '' ?>" onclick="toggleLike('<?= $post['id'] ?>', this)">
                        <?= $isLiked ? '❤️' : '🤍' ?>
                    </button>
                    <button class="action-btn" onclick="focusComment('<?= $post['id'] ?>')">💬</button>
                </div>

                <div class="likes-count" id="likes-count-<?= $post['id'] ?>">
                    <?= $likesCount ?> Me gusta
                </div>

                <div class="caption">
                    <span class="username"><?= htmlspecialchars($author['username']) ?></span>
                    <?= htmlspecialchars($post['caption']) ?>
                </div>

                <div class="comments-list" id="comments-<?= $post['id'] ?>">
                    <?php if (isset($post['comments']) && is_array($post['comments'])): ?>
                        <?php foreach ($post['comments'] as $comment): ?>
                            <div class="comment">
                                <span class="comment-user"><?= htmlspecialchars($comment['username']) ?></span>
                                <?= htmlspecialchars($comment['text']) ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <time class="time"><?= date('d F', strtotime($post['created_at'])) ?></time>

                <form class="comment-form" onsubmit="postComment(event, '<?= $post['id'] ?>')">
                    <input type="text" class="comment-input" placeholder="Añade un comentario..." id="input-<?= $post['id'] ?>">
                    <button type="submit" class="comment-submit">Publicar</button>
                </form>
            </article>
        <?php endforeach; ?>
    </main>

    <script>
        async function toggleLike(postId, btn) {
            try {
                const response = await fetch('actions/toggle_like.php', {
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
                    btn.innerHTML = data.liked ? '❤️' : '🤍';
                    btn.classList.toggle('liked', data.liked);
                    document.getElementById('likes-count-' + postId).innerText = data.count + ' Me gusta';
                }
            } catch (e) {
                console.error('Error toggling like');
            }
        }

        async function postComment(e, postId) {
            e.preventDefault();
            const input = document.getElementById('input-' + postId);
            const text = input.value.trim();
            if (!text) return;

            try {
                const response = await fetch('actions/add_comment.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        post_id: postId,
                        text: text
                    })
                });
                const data = await response.json();

                if (data.success) {
                    const commentList = document.getElementById('comments-' + postId);
                    const div = document.createElement('div');
                    div.className = 'comment';
                    div.innerHTML = `<span class="comment-user">${data.comment.username}</span> ${data.comment.text}`;
                    commentList.appendChild(div);
                    input.value = '';
                    commentList.scrollTop = commentList.scrollHeight; // Scroll to bottom
                }
            } catch (e) {
                console.error('Error posting comment');
            }
        }

        async function deletePost(postId) {
            if (!confirm('¿Borrar publicación?')) return;

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
                    alert('No se pudo borrar');
                }
            } catch (e) {
                console.error('Error deleting post');
            }
        }

        function focusComment(postId) {
            document.getElementById('input-' + postId).focus();
        }
    </script>
</body>

</html>