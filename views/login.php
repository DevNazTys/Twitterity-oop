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
        <a href="/" class="logo-welcome">Twitterity</a>
        <div class="login-form">
            <h2>Login</h2>
            <?php if (!empty($error)) echo "<p style='color: red;'>$error</p>"; ?>
            <form action="" method="post">
                <label for="email">Email Address</label><br>
                <input type="email" name="email" id="email" class="form-control"><br>

                <label for="password">Password</label><br>
                <input type="password" name="password" id="password" class="form-control"><br>

                <input type="submit" name="submit" class="btn-login" value="Submit"><br>
                <p>Don't have an account? <a href="/register">Register here</a>.</p>
            </form>
        </div>
    </div>
</div>
</body>
</html> 