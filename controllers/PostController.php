<?php

require_once __DIR__ . '/../classes/Post.php';
require_once __DIR__ . '/../classes/Auth.php';

class PostController {
    
    public static function createPost() {
        Auth::requireLogin();
        
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            header("Location: /dashboard");
            exit;
        }

        $content = trim($_POST['content'] ?? '');
        $userId = Auth::getCurrentUserId();

        if (!empty($content)) {
            $post = new Post();
            $result = $post->create($userId, $content);
            
            if ($result['success']) {
                echo 'The post is successfully created';
            } else {
                echo 'Error creating post: ' . $result['message'];
            }
        }

        header("Location: /dashboard");
        exit;
    }

    public static function editPost() {
        Auth::requireLogin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['error' => 'Invalid request method']);
            return;
        }

        $postId = intval($_POST['post_id'] ?? 0);
        $newContent = trim($_POST['content'] ?? '');

        if (empty($newContent)) {
            echo json_encode(['error' => 'Content cannot be empty']);
            return;
        }

        $post = new Post($postId);
        if (!$post->getId()) {
            echo json_encode(['error' => 'Post not found']);
            return;
        }

        // Check if current user owns the post
        if ($post->getUserId() !== Auth::getCurrentUserId()) {
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }

        $result = $post->update($newContent);
        
        if ($result['success']) {
            echo json_encode(['message' => 'Post updated']);
        } else {
            echo json_encode(['error' => $result['message']]);
        }
    }

    public static function deletePost() {
        Auth::requireLogin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['error' => 'Invalid request method']);
            return;
        }

        $postId = intval($_POST['post_id'] ?? 0);

        $post = new Post($postId);
        if (!$post->getId()) {
            echo json_encode(['error' => 'Post not found']);
            return;
        }

        // Check if current user owns the post
        if ($post->getUserId() !== Auth::getCurrentUserId()) {
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }

        $result = $post->delete();
        
        if ($result['success']) {
            echo json_encode(['message' => 'Post deleted']);
        } else {
            echo json_encode(['error' => $result['message']]);
        }
    }

    public static function getUserPosts($userId) {
        return Post::getPostsByUserId($userId);
    }

    public static function getAllPosts() {
        return Post::getAllPostsWithUsers();
    }

    // New methods for clean URL routing
    public static function create() {
        self::createPost();
    }

    public static function edit() {
        self::editPost();
    }

    public static function delete() {
        Auth::requireLogin();
        
        // Extract post ID from URL path
        $uri = $_SERVER['REQUEST_URI'];
        $uriParts = explode('/', trim($uri, '/'));
        $postId = intval(end($uriParts));

        if (!$postId) {
            echo json_encode(['error' => 'Invalid post ID']);
            return;
        }

        $post = new Post($postId);
        if (!$post->getId()) {
            echo json_encode(['error' => 'Post not found']);
            return;
        }

        // Check if current user owns the post
        if ($post->getUserId() !== Auth::getCurrentUserId()) {
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }

        $result = $post->delete();
        
        if ($result['success']) {
            echo json_encode(['message' => 'Post deleted']);
        } else {
            echo json_encode(['error' => $result['message']]);
        }
    }
} 