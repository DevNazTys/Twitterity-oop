<?php
session_start();

// Перевірка, чи користувач авторизований
if (!isset($_SESSION['userid'])) {
    echo '<p>Користувач не авторизований.</p>';
    exit;
}

require_once "config.php";

$userId = $_SESSION['userid'];

// Отримання постів користувача
$query = "SELECT content, created_at FROM posts WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $db->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo '<p>У вас немає жодного поста.</p>';
} else {
    while ($post = $result->fetch_assoc()) {
        echo '<div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">';
        echo '<p>' . htmlspecialchars($post['content']) . '</p>';
        echo '<small>Опубліковано: ' . $post['created_at'] . '</small>';
        echo '</div>';
    }
}

$stmt->close();
$db->close();
?>