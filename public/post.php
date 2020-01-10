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
    $statement = $pdo->prepare('SELECT * FROM posts WHERE id = :post_id');
    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }
    $statement->bindParam(':post_id', $postId, PDO::PARAM_INT);
    $statement->execute();
    $post = $statement->fetch();

    ?>
    <article class="main">

        <div class="postUserSection">

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
                <form action="/app/posts/update.php?id=<?php echo $post['id']; ?>" method="post">
                    <button class="editButton"><img class="editIcon" src="/assets/images/editicon.svg" alt="Edit"></button>
                </form>
                <form action="/app/posts/delete.php?id=<?php echo $post['id']; ?>" method="post">
                    <button class="deleteButton"><img class="deleteIcon" src="/assets/images/deleteicon.svg" alt="Delete"></button>
                </form>
            </div>

        <?php endif; ?>



    <?php endif; ?>


    <form action="/app/comments/store.php" method="post" enctype="multipart/form-data">

        <label for="content"></label>
        <textarea class="commentInput" name="content" cols="30" rows="3">
    </textarea>

        <button class="commentsButton" type="submit">Comment</button>

    </form>
    </article>

    <?php require __DIR__ . '/views/footer.php'; ?>







    <!-- <div class="post">
        <h8><?php echo $post['date']; ?></h8>
        <h7><?php echo $post['content']; ?></h7>
        <?php if (!($post['image'] === NULL || $post['image'] === 'EMPTY')) : ?>

<img src="/app/uploads/images/<?php echo $post['image']; ?>" class="postImage" alt="">

<?php endif; ?>

<form method="post" action="app/posts/likes.php">

<input name="postId" type="hidden" value="<?php echo $post['id']; ?>">
<?php if (hasBeenLiked($user['id'], $post['id'], $pdo)) : ?>

    <button class="likeButton" type="submit"> <img src="/assets/images/redlike.png" class="likeImage" alt=""> </button>

<?php else : ?>

    <button class="likeButton" type="submit"> <img src="/assets/images/bluelike.png" class="likeImage" alt=""> </button>

<?php endif; ?>
</form>

<?php echo "Amount of likes: " . getAmountOfLikes($post['id'], $pdo); ?>


<?php if ($user['id'] === $post['author_id']) : ?>

<form action="/app/posts/delete.php?id=<?php echo $post['id']; ?>" method="post">
    <button>Delete post</button>
</form>

<form action="/app/posts/update.php?id=<?php echo $post['id']; ?>" method="post">
    <button>Edit post</button>
</form>
<?php endif; ?>
</div> -->