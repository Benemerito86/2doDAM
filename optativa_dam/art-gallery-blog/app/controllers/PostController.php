<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Post.php';

class PostController extends Controller
{
    public function __construct()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
    }

    public function index()
    {
        $postModel = new Post();
        $posts = $postModel->getAll();

        // Enrich with current user like status and comments
        foreach ($posts as &$post) {
            $post['is_liked'] = $postModel->isLikedBy($post['id'], $_SESSION['user_id']);
            $post['comments'] = $postModel->getComments($post['id']);
        }

        $this->view('home/index', ['posts' => $posts]);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $caption = trim($_POST['caption']);
            $imageUrl = trim($_POST['image_url']);

            // Handle file upload if present
            if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === 0) {
                $uploadDir = __DIR__ . '/../../public/uploads/';
                $ext = pathinfo($_FILES['image_file']['name'], PATHINFO_EXTENSION);
                $filename = uniqid() . '.' . $ext;

                if (move_uploaded_file($_FILES['image_file']['tmp_name'], $uploadDir . $filename)) {
                    $imageUrl = 'uploads/' . $filename;
                }
            }

            if ($imageUrl) {
                $postModel = new Post();
                $postModel->create($_SESSION['user_id'], $caption, $imageUrl);
                $this->redirect('/');
            }
        }
        $this->view('posts/create');
    }

    // API Methods
    public function toggleLike()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $postId = $data['post_id'] ?? 0;

        $postModel = new Post();
        $liked = $postModel->toggleLike($postId, $_SESSION['user_id']);
        $count = $postModel->getLikesCount($postId);

        $this->json(['success' => true, 'liked' => $liked, 'count' => $count]);
    }

    public function addComment()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $postId = $data['post_id'] ?? 0;
        $text = trim($data['text'] ?? '');

        if ($text) {
            $postModel = new Post();
            $postModel->addComment($postId, $_SESSION['user_id'], $text);
            $this->json(['success' => true, 'username' => $_SESSION['username'], 'text' => htmlspecialchars($text)]);
        }
        $this->json(['success' => false]);
    }

    public function delete()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $postId = $data['post_id'] ?? 0;

        $isAdmin = ($_SESSION['role'] ?? '') === 'admin';

        $postModel = new Post();
        if ($postModel->delete($postId, $_SESSION['user_id'], $isAdmin)) {
            $this->json(['success' => true]);
        } else {
            $this->json(['success' => false, 'message' => 'Permission denied']);
        }
    }
}
