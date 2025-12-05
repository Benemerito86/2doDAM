<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Post.php';

class ProfileController extends Controller
{
    public function __construct()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
    }

    public function show($username = null)
    {
        if (!$username) {
            $username = $_SESSION['username'];
        }

        $userModel = new User();
        $user = $userModel->findByUsername($username);

        if (!$user) {
            die("Usuario no encontrado");
        }

        $postModel = new Post();
        $posts = $postModel->getByUserId($user['id']);

        // Enrich
        foreach ($posts as &$post) {
            $post['likes_count'] = $postModel->getLikesCount($post['id']);
            $post['comments_count'] = count($postModel->getComments($post['id']));
        }

        $this->view('profile/show', ['user' => $user, 'posts' => $posts]);
    }
}
