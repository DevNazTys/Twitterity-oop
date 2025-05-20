<?php
require_once 'session.php';
require_once 'config.php';

$content = trim($_POST['content'] ?? '');
var_dump($content);

    // Отримання даних з POST-запиту
    $content = trim($_POST['content'] ?? '');
    var_dump($content);
    $userId = $_SESSION['userid'];

    if (!empty($content)) {
        $stmt = $db->prepare("INSERT INTO posts (user_id, content) VALUES (?, ?)");
        $stmt->bind_param("is", $userId, $content);

        if ($stmt->execute()) {
            echo 'The post is successfully created';
        } else {
            echo 'Error creating post: ' . $stmt->error;
        }

        $stmt->close();
        $db->close();
    }

header("Location: homepage.php");
