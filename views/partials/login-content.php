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