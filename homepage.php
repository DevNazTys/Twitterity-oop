<?php
require_once "session.php";
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
            <h1>Hello, <strong><?php echo $_SESSION['name']; ?></strong>. Welcome to Twitterity.</h1>
        </div>
        <p>
            <a href="logout.php" class="btn btn-secondary btn-lg active" role="button" aria-pressed="true">Log Out</a>
        </p>
    </div>
</div>

<!-- тут можна створити навігацію, щоб переглядати пости всіх інших юзерів-->
<a href="view.php">View Records</a><br>
<p><a href="insert.php">Insert New Record</a></p>
<a href="post_create.php">Create post</a><br>
<a href="flex.php">Flex</a><br>


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