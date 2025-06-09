<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My Posts</title>
    <link rel="stylesheet" href="css/style.css?v=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jaro:opsz@6..72&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
          integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
          crossorigin="anonymous"
          referrerpolicy="no-referrer"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="wrapper">
    <div class="aside-1">
        <div class="aside-1-1">
            <div class="header">
                <span class="logo">Twitterity</span>
                <nav class="navbar">
                    <a href="homepage.php"><i class="fa-regular fa-user"></i>My posts</a>
                    <a href="allPosts.php"><i class="fa-solid fa-globe"></i>All posts</a>
                </nav>
                <div class="crtpost" id="createPost"><button>Create post</button href="#"></div>
                <span class="logout"><a href="logout.php">Logout</a></span>
            </div>
        </div>
    </div>
    <div class="main">
        <div class="welcome"><?php echo Auth::getCurrentUserName();?></div>

        <div class="vievpost">
            <!-- modal window for creating posts -->
            <div id="wcp" class="wcp">
                <div class="wcpContent">
                    <span id="closeWcpBtn" class="close">&times;</span>
                    <h1 style="margin: 5px; color: gold"><?php echo Auth::getCurrentUserName();?></h1>
                    <form action="create.php" method="post">
                        <textarea name="content" id="content" class="crtpostTxtArea" placeholder="Введіть текст..."></textarea>
                        <button type="submit" class="crtpostBtn">Create post</button>
                    </form>
                </div>
            </div>

            <!-- modal window for editing posts -->
            <div id="editPostModal" class="wep">
                <div class="wepContent">
                    <h1>Редагувати пост</h1>
                    <textarea id="newContent" class="editPostTxtArea" placeholder="Введіть новий текст поста..."></textarea>
                    <div class="wep-buttons">
                        <button class="editPostBtn" id="saveButton">Зберегти</button>
                        <button class="editPostBtn" id="cancelButton">Скасувати</button>
                    </div>
                </div>
            </div>

            <!-- loading posts from the database -->
            <div class="postlist">
                <?php if (!empty($posts)): ?>
                    <?php foreach ($posts as $post): ?>
                        <div class="vievpostitem" id="post-<?php echo $post['id']; ?>">
                            <div class="post-actions">
                                <button class="btn-delete" onclick="deletePost(<?php echo $post['id']; ?>)"><i class="fa-solid fa-trash"></i></button>
                                <button class="btn-edit" onclick="editPost(<?php echo $post['id']; ?>)"><i class="fa-solid fa-pen"></i></button>
                                <?php $time_ago = Post::calculateTimeAgo($post['created_at']); ?>
                                <?php echo '@' . Auth::getCurrentUserName() . ' &middot ' . '<small>' . $time_ago . '</small>' ?>
                                <p><?php echo htmlspecialchars($post['content']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="no-posts">You have no posts yet</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="aside-2"></div>
</div>
<script src="script.js"></script>
</body>
</html> 