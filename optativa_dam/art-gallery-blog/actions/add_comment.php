<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$postId = $input['post_id'] ?? null;
$text = trim($input['text'] ?? '');
$userId = $_SESSION['user_id'];
$username = $_SESSION['username'];

if (!$postId || empty($text)) {
    echo json_encode(['success' => false, 'message' => 'Missing data']);
    exit;
}

$postsFile = '../data/posts.json';
$posts = json_decode(file_get_contents($postsFile), true) ?? [];

$found = false;
$newComment = null;

foreach ($posts as &$post) {
    if ($post['id'] === $postId) {
        $found = true;

        if (!isset($post['comments']) || !is_array($post['comments'])) {
            $post['comments'] = [];
        }

        $newComment = [
            'id' => uniqid('c'),
            'user_id' => $userId,
            'username' => $username,
            'text' => htmlspecialchars($text),
            'created_at' => date('Y-m-d H:i:s')
        ];

        $post['comments'][] = $newComment;
        break;
    }
}

if ($found) {
    file_put_contents($postsFile, json_encode($posts, JSON_PRETTY_PRINT));
    echo json_encode(['success' => true, 'comment' => $newComment]);
} else {
    echo json_encode(['success' => false, 'message' => 'Post not found']);
}
