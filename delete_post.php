<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id = intval($_POST['post_id']);

    $query = "DELETE FROM posts WHERE id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $post_id);

    if ($stmt->execute()) {
        echo json_encode(['message' => 'Post deleted']);
    } else {
        echo json_encode(['error' => 'Database error']);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'Invalid query method']);
}