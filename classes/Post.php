<?php

require_once 'Database.php';

class Post {
    private $db;
    private $id;
    private $userId;
    private $content;
    private $createdAt;

    public function __construct($id = null) {
        $this->db = Database::getInstance();
        if ($id) {
            $this->loadPost($id);
        }
    }

    private function loadPost($id) {
        $stmt = $this->db->prepare("SELECT * FROM posts WHERE id = ?");
        $stmt->execute([$id]);
        $post = $stmt->fetch();
        
        if ($post) {
            $this->id = $post['id'];
            $this->userId = $post['user_id'];
            $this->content = $post['content'];
            $this->createdAt = $post['created_at'];
        }
    }

    public function create($userId, $content) {
        if (empty($content)) {
            return ['success' => false, 'message' => 'Content cannot be empty'];
        }

        try {
            $stmt = $this->db->prepare("INSERT INTO posts (user_id, content) VALUES (?, ?)");
            if ($stmt->execute([$userId, $content])) {
                $this->id = $this->db->lastInsertId();
                $this->userId = $userId;
                $this->content = $content;
                return ['success' => true, 'message' => 'Post created successfully'];
            } else {
                return ['success' => false, 'message' => 'Error creating post'];
            }
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }

    public function update($content) {
        if (empty($content)) {
            return ['success' => false, 'message' => 'Content cannot be empty'];
        }

        try {
            $stmt = $this->db->prepare("UPDATE posts SET content = ? WHERE id = ?");
            if ($stmt->execute([$content, $this->id])) {
                $this->content = $content;
                return ['success' => true, 'message' => 'Post updated successfully'];
            } else {
                return ['success' => false, 'message' => 'Error updating post'];
            }
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }

    public function delete() {
        try {
            $stmt = $this->db->prepare("DELETE FROM posts WHERE id = ?");
            if ($stmt->execute([$this->id])) {
                return ['success' => true, 'message' => 'Post deleted successfully'];
            } else {
                return ['success' => false, 'message' => 'Error deleting post'];
            }
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }

    public static function getUserPosts($userId) {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM posts WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$userId]);
        $posts = $stmt->fetchAll();
        
        $postObjects = [];
        foreach ($posts as $postData) {
            $post = new self();
            $post->id = $postData['id'];
            $post->userId = $postData['user_id'];
            $post->content = $postData['content'];
            $post->createdAt = $postData['created_at'];
            $postObjects[] = $post;
        }
        
        return $postObjects;
    }

    public static function getAllPostsWithUsers() {
        $db = Database::getInstance();
        $stmt = $db->prepare("
            SELECT posts.*, users.name, users.email 
            FROM posts 
            JOIN users ON posts.user_id = users.id 
            ORDER BY posts.created_at DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getPostsByUserId($userId) {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM posts WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public static function calculateTimeAgo($datetime) {
        $now = new DateTime();
        $created_at = new DateTime($datetime);
        $diff = $now->diff($created_at);
        
        if ($diff->y > 0) {
            return $diff->y . ' years ago';
        } elseif ($diff->m > 0) {
            return $diff->m . ' months ago';
        } elseif ($diff->d > 0) {
            return $diff->d . ' days ago';
        } elseif ($diff->h > 0) {
            return $diff->h . ' hours ago';
        } elseif ($diff->i > 0) {
            return $diff->i . ' minutes ago';
        } elseif ($diff->s > 0) {
            return $diff->s . ' seconds ago';
        }
        return 'just now';
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function getContent() {
        return $this->content;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    // Setters
    public function setContent($content) {
        $this->content = $content;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }
} 