<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id = intval($_POST['post_id']);
    $new_content = trim($_POST['content']);

    if (empty($new_content)) {
        exit;
    }

    $query = "UPDATE posts SET content = ? WHERE id = ?";
    $stmt = $db->prepare($query);

    if ($stmt->execute([$new_content, $post_id])) {
        echo json_encode(['message' => 'Post updated']);
    } else {
        echo json_encode(['error' => 'Database error']);
    }
} else {
    echo json_encode(['error' => 'Invalid query method']);
}