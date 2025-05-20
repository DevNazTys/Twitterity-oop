<?php
session_start();
require_once "config.php";
if (isset($_SESSION["userid"]) && $_SESSION["userid"] === true) {
    header("location: homepage.php");
    exit;
}

$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // validate if email is empty
    if (empty($email)) {
        $error .= "Please enter email.";
    } elseif (empty($password)) {     // validate if password is empty
        $error .= "Please enter your password.";
    }

    if (empty($error)) {
        if($query = $db->prepare("SELECT * FROM users WHERE email = ?")) {
            $query->bind_param('s', $email);
            $query->execute();
            $result = $query->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
            }
            if ($row) {
                if (password_verify($password, $row['password'])) {
                    $_SESSION["userid"] = $row['id'];
                    $_SESSION["name"] = $row['name'];

                    // Redirect the user to welcome page
                    header("location: homepage.php");
                    exit;
                } else {
                    $error .= '<p class="error">The password is not valid.</p>';
                }
            } else {
                $error .= '<p class="error">No User exist with that email address.</p>';
            }
        }
        $query->close();
    }
    mysqli_close($db);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css?v=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jaro:opsz@6..72&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
<div class="container-login">
    <div class="login-window">
        <span class="logo-welcome">Twitterity</span>
        <div class="login-form">
            <h2>Login</h2>
            <?php if (!empty($error)) echo "<p style='color: red;'>$error</p>"; ?>
            <form action="" method="post">
                <label for="email">Email Address</label><br>
                <input type="email" name="email" id="email" class="form-control"><br>

                <label for="password">Password</label><br>
                <input type="password" name="password" id="password" class="form-control"><br>

                <input type="submit" name="submit" class="btn-login" value="Submit"><br>
                <p>Don't have an account? <a href="register.php">Register here</a>.</p>
            </form>
        </div>
    </div>
</div>
</body>
</html>