<?php
session_start();

require_once 'config.php';

// Перевірка, чи користувач авторизований
if (!isset($_SESSION['userid'])) {
    echo json_encode(['error' => 'Користувач не авторизований']);
    exit;
}

$content = trim($_POST['content'] ?? '');
var_dump($content);

    // Отримання даних з POST-запиту
    $content = trim($_POST['content'] ?? '');
    var_dump($content);
    $userId = $_SESSION['userid'];

    if (!empty($content)) {
        // Вставка нового поста в базу даних
        $stmt = $db->prepare("INSERT INTO posts (user_id, content) VALUES (?, ?)");
        $stmt->bind_param("is", $userId, $content);

        if ($stmt->execute()) {
            echo 'Пост успішно створено';
        } else {
            echo 'Помилка при створенні поста: ' . $stmt->error;
        }

        $stmt->close();
        $db->close();
    }

header("Location: homepage.php");
?>
