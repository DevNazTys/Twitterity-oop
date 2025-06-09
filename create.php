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
        
        if ($stmt->execute([$userId, $content])) {
            echo 'The post is successfully created';
        } else {
            echo 'Error creating post';
        }
    }

header("Location: homepage.php");
