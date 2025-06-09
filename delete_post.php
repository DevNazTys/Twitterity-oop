<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id = intval($_POST['post_id']);

    $query = "DELETE FROM posts WHERE id = ?";
    $stmt = $db->prepare($query);

    if ($stmt->execute([$post_id])) {
        echo json_encode(['message' => 'Post deleted']);
    } else {
        echo json_encode(['error' => 'Database error']);
    }
} else {
    echo json_encode(['error' => 'Invalid query method']);
}