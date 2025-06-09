<div class="wrapper">
    <div class="aside-1">
        <div class="aside-1-1">
            <div class="header">
                <span class="logo">Twitterity</span>
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
                    <h1 style="margin: 5px"><?php echo Auth::getCurrentUserName();?></h1>
                    <form action="/post/create" method="post">
                        <textarea name="content" id="content" class="crtpostTxtArea" placeholder="Введіть текст..."></textarea>
                        <button type="submit" class="crtpostBtn">Create post</button>
                    </form>
                </div>
            </div>

            <!-- loading posts from the database -->
            <div class="postlist">
                <?php if (!empty($posts)): ?>
                    <?php foreach ($posts as $post): ?>
                        <div class="vievpostitem" id="post-<?php echo $post['id']; ?>">
                            <div class="post-actions">
                                <?php $time_ago = Post::calculateTimeAgo($post['created_at']); ?>
                                <?php echo '@' . htmlspecialchars($post['name']) . ' &middot ' . '<small>' . $time_ago . '</small>' ?>
                                <p><?php echo htmlspecialchars($post['content']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Немає постів.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="aside-2"></div>
</div> 