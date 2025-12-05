<?php
require_once __DIR__ . '/../core/Database.php';

class User
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function findByUsername($username)
    {
        $users = $this->db->read('users');
        foreach ($users as $user) {
            if ($user['username'] === $username) {
                return $user;
            }
        }
        return false;
    }

    public function findById($id)
    {
        $users = $this->db->read('users');
        foreach ($users as $user) {
            if ($user['id'] == $id) {
                return $user;
            }
        }
        return false;
    }

    public function register($name, $username, $password, $avatar = null)
    {
        if ($this->findByUsername($username)) {
            return false;
        }

        $users = $this->db->read('users');
        $id = $this->db->nextId('users');

        $hash = password_hash($password, PASSWORD_DEFAULT);
        if (!$avatar) {
            $avatar = 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&background=random';
        }

        $newUser = [
            'id' => $id,
            'name' => $name,
            'username' => $username,
            'password' => $hash,
            'avatar' => $avatar,
            'role' => 'user',
            'created_at' => date('Y-m-d H:i:s')
        ];

        $users[] = $newUser;
        $this->db->write('users', $users);
        return true;
    }

    public function login($username, $password)
    {
        $user = $this->findByUsername($username);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
}
