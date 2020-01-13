<?php

declare(strict_types=1);

require __DIR__ . '/views/header.php'; ?>

<?php
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
}



if (isset($_GET['id'])) : ?>
    <?php
    $postId = $_GET['id'];
    $statement = $pdo->prepare('SELECT posts.*, users.name, users.avatar FROM posts INNER JOIN users ON posts.author_id = users.id WHERE posts.id = :post_id');
    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }
    $statement->bindParam(':post_id', $postId, PDO::PARAM_INT);
    $statement->execute();
    $post = $statement->fetch();


    // GET ALL COMMENTS
    $statement = $pdo->prepare("SELECT post_comments.*, users.name, users.avatar FROM post_comments INNER JOIN users ON post_comments.user_id = users.id WHERE post_id = :postId ORDER BY date asc");
    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }
    $statement->bindParam(':postId', $postId, PDO::PARAM_INT);
    $statement->execute();
    $comments = $statement->fetchAll(PDO::FETCH_ASSOC);
    ?>


    <article class="main">

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

            <?php echo getAmountOfLikes($post['id'], $pdo) . ' has voffed this post';  ?>

        </div>

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

    <?php endif; ?>

    <h1 class="commentHeader">Comments</h1>

    <!-- COMMENTS BELOW -->
    <?php
    foreach ($comments as $comment) : ?>
        <div class="comment">
            <h8 class="postDate">Posted: <?php echo $comment['date']; ?></h8> <br>
            <div class="postUserSection">
                <h7 class="postUserName"> <?php echo $comment['name']; ?></h7>
                <div class="postAvatarFrame">
                    <img src="/app/uploads/avatars/<?php echo $comment['avatar']; ?>" class="postAvatar" alt="">
                </div>


            </div>

            <?php if (!($comment['image'] === NULL || $comment['image'] === 'EMPTY')) : ?>

                <img src="/app/uploads/images/<?php echo $comment['image']; ?>" class="postImage" alt="">

            <?php endif; ?>

            <h7 class="postContent"><?php echo $comment['content']; ?></h7>
            <!-- <div class="postLikeSection">
                <form method="post" action="app/posts/likes.php">


                    <input name="postId" type="hidden" value="<?php echo $post['id']; ?>">
                    <?php if (hasBeenLiked($user['id'], $post['id'], $pdo)) : ?>

                        <button class="likeButton" type="submit"> <img src="/assets/images/redlike.png" class="likeImage" alt=""> </button>

                    <?php else : ?>

                        <button class="likeButton" type="submit"> <img src="/assets/images/bluelike.png" class="likeImage" alt=""> </button>

                    <?php endif; ?>
                </form>

                <?php echo getAmountOfLikes($post['id'], $pdo) . ' has voffed this post';  ?>

            </div> -->



            <?php if ($user['id'] === $comment['user_id']) : ?>
                <div class="postBottomSection">
                    <form action="/editcomment.php?id=<?php echo $comment['id']; ?>" method="post">
                        <button class="editButton"><img class="editIcon" src="/assets/images/editicon.svg" alt="Edit"></button>
                    </form>
                    <form action="/app/comments/delete.php?id=<?php echo $comment['id']; ?>" method="post">
                        <button class="deleteButton"><img class="deleteIcon" src="/assets/images/deleteicon.svg" alt="Delete"></button>
                    </form>
                </div>



            <?php endif; ?>
        </div>

    <?php endforeach; ?>




    <form action="/app/comments/store.php?id=<?php echo $post['id']; ?>" method="post" enctype="multipart/form-data">
        <label for="content"></label>
        <textarea class="commentInput" name="content" cols="30" rows="3" placeholder="Care to add something, dawg?">
    </textarea>
        <button class="commentsButton" type="submit">Comment</button>

    </form>
    </article>
    <br><br><br><br>

    <?php require __DIR__ . '/views/footer.php'; ?>