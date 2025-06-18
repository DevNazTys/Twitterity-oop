<div class="wrapper">
    <div class="aside-1">
        <div class="aside-1-1">
            <div class="header">
                <a href="/dashboard" class="logo">Twitterity</a>
                <nav class="navbar">
                    <a href="/dashboard"><i class="fa-regular fa-user"></i>My posts</a>
                    <a href="/posts"><i class="fa-solid fa-globe"></i>All posts</a>
                </nav>
                <div class="crtpost" id="createPost"><button>Create post</button></div>
                <span class="logout"><a href="/logout">Logout</a></span>
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
                    <form action="/post/create" method="post">
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
                                <?php $time_ago = Post::calculateTimeAgo($post['created_at']); ?>
                                <?php echo '@' . Auth::getCurrentUserName() . ' &middot ' . '<small>' . $time_ago . '</small>' ?>
                                <button class="btn-delete" onclick="deletePost(<?php echo $post['id']; ?>)"><i class="fa-solid fa-trash"></i></button>
                                <button class="btn-edit" onclick="editPost(<?php echo $post['id']; ?>)"><i class="fa-solid fa-pen"></i></button>
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