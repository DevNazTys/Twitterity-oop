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
    $stmt->bind_param("si", $new_content, $post_id);

    if ($stmt->execute()) {
        echo json_encode(['message' => 'Post updated']);
    } else {
        echo json_encode(['error' => 'Database error']);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'Invalid query method']);
}