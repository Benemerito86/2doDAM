<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$postId = $input['post_id'] ?? null;
$userId = $_SESSION['user_id'];

if (!$postId) {
    echo json_encode(['success' => false, 'message' => 'Post ID required']);
    exit;
}

$postsFile = '../data/posts.json';
$posts = json_decode(file_get_contents($postsFile), true) ?? [];

$found = false;
$liked = false;
$count = 0;

foreach ($posts as &$post) {
    if ($post['id'] === $postId) {
        $found = true;

        // Ensure likes is array
        if (!isset($post['likes']) || !is_array($post['likes'])) {
            $post['likes'] = [];
        }

        $key = array_search($userId, $post['likes']);
        if ($key !== false) {
            // Unlike
            unset($post['likes'][$key]);
            $post['likes'] = array_values($post['likes']); // Reindex
            $liked = false;
        } else {
            // Like
            $post['likes'][] = $userId;
            $liked = true;
        }
        $count = count($post['likes']);
        break;
    }
}

if ($found) {
    file_put_contents($postsFile, json_encode($posts, JSON_PRETTY_PRINT));
    echo json_encode(['success' => true, 'liked' => $liked, 'count' => $count]);
} else {
    echo json_encode(['success' => false, 'message' => 'Post not found']);
}
