<?php
session_start();
require_once "config.php";
if (isset($_SESSION["userid"]) && $_SESSION["userid"] === true) {
    header("location: homepage.php");
    exit;
}

$error='';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST["confirm_password"]);

    // Data validation
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "Будь ласка, заповніть всі поля.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) { //FILTER_VALIDATE_EMAIL - вбудований фільтр в php
        $error = "Некоректний формат електронної пошти.";
    } elseif ($password !== $confirm_password) {
        $error = "Паролі не співпадають.";
    } elseif (strlen($password) < 8) {
        $error = "Пароль має бути не менше 8 символів.";
    } else { // Перевірка на існування користувача
        $check_db = "SELECT id FROM users WHERE email = ?";
        $check_query = $db->prepare($check_db); //підготовлюємо запит до БД ($bd) для пошуку користувачів з певним email
        $check_query->execute([$email]); //виконуємо пошук id з вказаним email
        $check_result = $check_query->fetch(); //повертаємо результат виконання запиту.
        
        if ($check_result) { //якщо знайшлись дані, то користувач існує
            $error = "Користувач з такою електронною поштою вже існує.";
        }
    }

    if (empty($error)) {

        $password_hash = password_hash($password, PASSWORD_BCRYPT); // Хешування паролю

        // SQL-запит для додавання нового користувача
        $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
        $query = $db->prepare($sql);

        try {
            // Виконання запиту
            if ($query->execute([$name, $email, $password_hash])) {
                $result= "Ви успішно зареєстровані!";
            } else {
                $result= "Помилка реєстрації";
            }
        } catch (PDOException $e) {
            $result= "Помилка підготовки запиту: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign up</title>
    <link rel="stylesheet" href="css/style.css?v=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jaro:opsz@6..72&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet"></head>
<body>
<div class="container-register">
    <div class="register-window">
        <span class="logo-welcome">Twitterity</span>
        <div class="register-form">
            <h2>Register</h2>
            <?php if (!empty($error)) echo "<p style='color: red;'>$error</p>"; ?>
            <?php if (!empty($result)) echo "<p style='color: green;'>$result</p>"; ?>
            <form action="" method="post">
                <label for="name">Enter your name:</label><br>
                <input type="text" name="name" id="name" class="form-control"><br>

                <label for="email">Enter your email:</label><br>
                <input type="email" name="email" id="email" class="form-control"><br>

                <label for="password">Password:</label><br>
                <input type="password" name="password" id="password" class="form-control"><br>

                <label for="confirm_password">Confirm password:</label><br>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control"><br>

                <input type="submit" value="Submit" class="btn-register"><br>
                <p>Already have an account? <a href="login.php">Login here</a></p>
            </form>
        </div>
    </div>
</div>
</body>
</html>
