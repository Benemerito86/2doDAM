<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Post.php';

class AuthController extends Controller
{
    public function login()
    {
        // Init DB dir if needed
        Database::getInstance();

        $error = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            $userModel = new User();
            $user = $userModel->login($username, $password);

            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['avatar'] = $user['avatar'];
                $this->redirect('/');
            } else {
                $error = "Usuario o contraseña inválidos.";
            }
        }
        $this->view('auth/login', ['error' => $error]);
    }

    public function register()
    {
        $error = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm = $_POST['confirm_password'] ?? '';

            if ($password !== $confirm) {
                $error = "Las contraseñas no coinciden.";
            } else {
                $userModel = new User();
                if ($userModel->register($name, $username, $password)) {
                    $this->redirect('/login');
                } else {
                    $error = "El usuario ya existe.";
                }
            }
        }
        $this->view('auth/register', ['error' => $error]);
    }

    public function logout()
    {
        session_destroy();
        $this->redirect('/login');
    }

    // Seed DB for demo purposes
    public function seed()
    {
        $userModel = new User();

        // Create Admin
        if (!$userModel->findByUsername('admin')) {
            $userModel->register('Administrador', 'admin', 'admin123', 'https://ui-avatars.com/api/?name=Admin&background=000&color=fff');
            // Update role manually in JSON
            $db = Database::getInstance();
            $users = $db->read('users');
            foreach ($users as &$u) {
                if ($u['username'] === 'admin') $u['role'] = 'admin';
            }
            $db->write('users', $users);
        }

        // Create User
        if (!$userModel->findByUsername('demo')) {
            $userModel->register('Demo User', 'demo', 'demo123');
        }

        // Create Sample Posts if empty
        $postModel = new Post();
        $posts = $postModel->getAll();
        if (empty($posts)) {
            $adminVal = $userModel->findByUsername('admin');
            $demoVal = $userModel->findByUsername('demo');

            if ($adminVal) {
                $postModel->create($adminVal['id'], "Bienvenido a ArtGram! 🎨", "https://images.unsplash.com/photo-1547891654-e66ed7ebb968?w=800&h=800&fit=crop");
            }
            if ($demoVal) {
                $postModel->create($demoVal['id'], "Mi primer boceto.", "https://images.unsplash.com/photo-1579783902614-a3fb3927b6a5?w=800&h=800&fit=crop");
            }
        }

        echo "Database seeded with JSON!";
    }
}
