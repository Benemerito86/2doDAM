<?php
require_once __DIR__ . '/../core/Database.php';

class Post
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll()
    {
        $posts = $this->db->read('posts');
        $users = $this->db->read('users');
        $likes = $this->db->read('likes');

        // Map users for manual join
        $userMap = [];
        foreach ($users as $u) $userMap[$u['id']] = $u;

        $result = [];
        foreach ($posts as $p) {
            $u = $userMap[$p['user_id']] ?? ['username' => 'Unknown', 'avatar' => '', 'name' => 'Unknown'];
            $p['username'] = $u['username'];
            $p['user_avatar'] = $u['avatar'];
            $p['user_name'] = $u['name'];

            // Count likes
            $p['likes_count'] = 0;
            foreach ($likes as $l) {
                if ($l['post_id'] == $p['id']) $p['likes_count']++;
            }

            $result[] = $p;
        }

        // Sort desc
        usort($result, function ($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });

        return $result;
    }

    public function getByUserId($userId)
    {
        $all = $this->getAll();
        return array_filter($all, function ($p) use ($userId) {
            return $p['user_id'] == $userId;
        });
    }

    public function create($userId, $caption, $image)
    {
        $posts = $this->db->read('posts');
        $id = $this->db->nextId('posts');

        $newPost = [
            'id' => $id,
            'user_id' => $userId,
            'image' => $image,
            'caption' => $caption,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $posts[] = $newPost;
        $this->db->write('posts', $posts);
        return true;
    }

    public function delete($postId, $userId, $isAdmin = false)
    {
        $posts = $this->db->read('posts');
        $found = false;

        foreach ($posts as $key => $post) {
            if ($post['id'] == $postId) {
                if ($post['user_id'] == $userId || $isAdmin) {
                    unset($posts[$key]);
                    $found = true;
                    // Also delete likes and comments ideally
                }
                break;
            }
        }

        if ($found) {
            $this->db->write('posts', array_values($posts));
            return true;
        }
        return false;
    }

    public function toggleLike($postId, $userId)
    {
        $likes = $this->db->read('likes');
        $foundKey = -1;

        foreach ($likes as $k => $l) {
            if ($l['post_id'] == $postId && $l['user_id'] == $userId) {
                $foundKey = $k;
                break;
            }
        }

        if ($foundKey !== -1) {
            // Unlike
            unset($likes[$foundKey]);
            $this->db->write('likes', array_values($likes));
            return false;
        } else {
            // Like
            $likes[] = ['user_id' => $userId, 'post_id' => $postId];
            $this->db->write('likes', $likes);
            return true;
        }
    }

    public function getLikesCount($postId)
    {
        $likes = $this->db->read('likes');
        $count = 0;
        foreach ($likes as $l) {
            if ($l['post_id'] == $postId) $count++;
        }
        return $count;
    }

    public function isLikedBy($postId, $userId)
    {
        $likes = $this->db->read('likes');
        foreach ($likes as $l) {
            if ($l['post_id'] == $postId && $l['user_id'] == $userId) return true;
        }
        return false;
    }

    public function addComment($postId, $userId, $text)
    {
        $comments = $this->db->read('comments');
        $id = $this->db->nextId('comments');
        $comments[] = [
            'id' => $id,
            'post_id' => $postId,
            'user_id' => $userId,
            'text' => htmlspecialchars($text),
            'created_at' => date('Y-m-d H:i:s')
        ];
        $this->db->write('comments', $comments);
        return true;
    }

    public function getComments($postId)
    {
        $comments = $this->db->read('comments');
        $users = $this->db->read('users');
        $userMap = [];
        foreach ($users as $u) $userMap[$u['id']] = $u;

        $postComments = [];
        foreach ($comments as $c) {
            if ($c['post_id'] == $postId) {
                $c['username'] = $userMap[$c['user_id']]['username'] ?? 'Unknown';
                $postComments[] = $c;
            }
        }
        return $postComments;
    }
}
