<?php require __DIR__ . '/views/header.php'; ?>
<?php

$user = $_SESSION['user'];
$id = $user['id'];
$date = date('Y/m/d h:i:s a', time());

$statement = $pdo->prepare('SELECT * FROM users WHERE id = :id');
$statement->execute([
    ':id' => $_SESSION['user']['id']
]);
$user = $statement->fetch(PDO::FETCH_ASSOC);

$statement = $pdo->prepare('SELECT * FROM posts WHERE author_id = :id ORDER BY date DESC');
$statement->execute([
    ':id' => $_SESSION['user']['id']
]);

$userPosts = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<article class="main">
    <div class="profileSection">
        <h2><?php echo $user['name']; ?></h2>
        <div class="profileAvatarFrame">
            <img class="profileAvatar" src="/app/uploads/avatars/<?php echo $user['avatar']; ?>" alt="Avatar">
        </div>
        <h3 class="profileEmail">Email: <?php echo $user['email']; ?></h3>
        <h3 class="profileBiography"><?php echo $user['biography']; ?></h3>
        <a href="/updateprofile.php"> <img src="/assets/images/settings.svg" class="settingsIcon" alt=""></a>
    </div>

    <form class="postForm" action="/app/posts/store.php" method="post" enctype="multipart/form-data">

        <label for="content"></label>
        <textarea class="postTextArea" name="content" cols="30" rows="3" placeholder="What do you want to tell the world, doggy?"></textarea>
        <br>
        <label for="Image">Add a pic dawg?</label>
        <input type="file" name="image">
        <br>
        <button class="formButton" type="submit">Post it doggy!</button>
    </form>

    <h4 class="latestPostText"> Latest posts by you</h4>

    <?php
    foreach ($userPosts as $post) : ?>
        <div class="post">
            <h8 class="postDate">Posted: <?php echo $post['date']; ?></h8> <br>

            <?php if (!($post['image'] === NULL || $post['image'] === 'EMPTY')) : ?>
                <img src="/app/uploads/images/<?php echo $post['image']; ?>" class="postImage" alt="">
            <?php endif; ?>

            <h7 class="postContent"><?php echo $post['content']; ?></h7>

            <div class="postLikeSection">
                <form method="post" action="app/posts/likes.php">
                    <input name="postId" type="hidden" value="<?php echo $post['id']; ?>">

                    <?php if (hasBeenLiked($user['id'], $post['id'], $pdo)) : ?>
                        <button class="likeButton" type="submit"> <img src="/assets/images/redlike.png" class="likeImage" alt=""> </button>
                    <?php else : ?>
                        <button class="likeButton" type="submit"> <img src="/assets/images/bluelike.png" class="likeImage" alt=""> </button>
                    <?php endif; ?>
                </form>

                <?php echo getAmountOfLikes($post['id'], $pdo) . ' has voffed this post';  ?>

            </div>

            <form action="/post.php?id=<?php echo $post['id']; ?>" method="post">
                <button class="commentsButton">Comments</button>
            </form>

            <?php if ($user['id'] === $post['author_id']) : ?>
                <div class="postBottomSection">
                    <form action="/editpost.php?id=<?php echo $post['id']; ?>" method="post">
                        <button class="editButton"><img class="editIcon" src="/assets/images/editicon.svg" alt="Edit"></button>
                    </form>

                    <form action="/app/posts/delete.php?id=<?php echo $post['id']; ?>" method="post">
                        <button class="deleteButton"><img class="deleteIcon" src="/assets/images/deleteicon.svg" alt="Delete"></button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</article>

<?php require __DIR__ . '/views/footer.php'; ?>