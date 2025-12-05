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

// Get user role
$usersFile = '../data/users.json';
$users = json_decode(file_get_contents($usersFile), true) ?? [];
$isAdmin = false;
foreach ($users as $u) {
    if ($u['id'] === $userId && isset($u['role']) && $u['role'] === 'admin') {
        $isAdmin = true;
        break;
    }
}

$postsFile = '../data/posts.json';
$posts = json_decode(file_get_contents($postsFile), true) ?? [];

$initialCount = count($posts);
$posts = array_filter($posts, function ($post) use ($userId, $isAdmin, $postId) {
    if ($post['id'] === $postId) {
        // Allow delete if owner OR admin
        if ($post['user_id'] === $userId || $isAdmin) {
            return false; // Remove
        }
    }
    return true; // Keep
});

if (count($posts) < $initialCount) {
    file_put_contents($postsFile, json_encode(array_values($posts), JSON_PRETTY_PRINT));
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Post not found or permission denied']);
}
