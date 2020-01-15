<?php require __DIR__ . '/views/header.php';


$statement = $pdo->prepare('SELECT posts.*, users.name, users.avatar FROM posts INNER JOIN users ON posts.author_id = users.id ORDER BY date DESC');
if (!$statement) {
    die(var_dump($pdo->errorInfo()));
}
$statement->execute();
$posts = $statement->fetchAll(PDO::FETCH_ASSOC);


?>

<article>
    <!-- IF USER IS NOT LOGGED IN, DISPLAY BELOW.  -->
    <?php if (!(isset($_SESSION['user']))) : ?>

        <article class="main">
            <h1 class="header">Welcome, dog. </h1>
            <h3>Log in below</h3>

            <?php if (isset($_SESSION['error'])) : ?>
                <h1 class="error"> <?php echo $_SESSION['error']; ?> </h1>
                <?php unset($_SESSION['error']); ?>

            <?php endif; ?>


            <form action="app/users/login.php" method="post">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input class="form-control" type="email" name="email" placeholder="oldDog@email.com" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input class="form-control" type="password" name="password" required>
                </div>

                <button class="mainButton" type="submit">Enter</button>
            </form>

            <h4 class="register">Haven't been here before?</h4>
            <a href="/register.php"> <button class="mainButton">Well register yourself, puppy</button></a>
        </article>

    <?php endif;  ?>


    <!-- IF USER IS LOGGED IN, DISPLAY BELOW.  -->
    <?php if (isset($_SESSION['user'])) : ?>
        <?php $user = $_SESSION['user']; ?>
        <article class="main">

            <h2> Latest posts </h2>

            <?php
            foreach ($posts as $post) : ?>
                <div class="post">
                    <div class="postUserSection">
                        <h7 class="postUserName"> <?php echo $post['name']; ?></h7>
                        <img src="/app/uploads/avatars/<?php echo $post['avatar']; ?>" class="postAvatar" alt="">
                    </div>

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

                        <?php echo getAmountOfLikes($post['id'], $pdo) . ' has thrown a bone to this post';  ?>
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
    <?php endif; ?>
</article>

<?php require __DIR__ . '/views/footer.php'; ?>