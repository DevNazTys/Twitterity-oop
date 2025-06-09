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
                <p>Already have an account? <a href="/login">Login here</a></p>
            </form>
        </div>
    </div>
</div> 