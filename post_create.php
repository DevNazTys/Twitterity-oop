<?php

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<h1>Створити пост</h1>
<form action="create.php" method="post" id="postForm">
    <textarea name="content" id="content" rows="5" placeholder="Введіть текст поста..." required></textarea><br><br>
    <button type="submit">Опублікувати</button>
</form>

</body>
</html>
