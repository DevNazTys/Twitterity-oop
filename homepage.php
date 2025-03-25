<?php
// start the session
session_start();

// Check if the user is not logged in, then redirect the user to login page
if (!isset($_SESSION["userid"]) || empty($_SESSION["userid"])) {
    header("location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome <?php echo $_SESSION["name"]; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Hello, <strong><?php echo $_SESSION['name']; ?></strong>. Welcome to demo site.</h1>
        </div>
        <p>
            <a href="logout.php" class="btn btn-secondary btn-lg active" role="button" aria-pressed="true">Log Out</a>
        </p>
    </div>
</div>

<a href="post_create.php">Create post</a>


<h2>Мої пости</h2>
<div id="postsList"></div>

<?php $id = $_SESSION['userid']; ?>

<script>
    $(document).ready(function () {

        // Завантаження постів при завантаженні сторінки
        function loadPosts() {
            $.ajax({
                url: `user_posts.php`,
                method: 'GET',
                success: function (response) {
                    $('#postsList').html(response);
                },
                error: function () {
                    $('#postsList').html('<p>Помилка при завантаженні постів.</p>');
                }
            });
        }

        loadPosts(); // Перше завантаження постів
    });
</script>
</body>
</html>