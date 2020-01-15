<?php

declare(strict_types=1);

require __DIR__ . '/views/header.php'; ?>

<?php
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
} ?>



<?php

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
    if ($user['id'] !== $post['author_id']) {
        redirect('/index.php');
    }
    ?>
<?php endif; ?>

<article class="main">

    <h4>Edit post</h4>

    <div class="postUserSection">

    </div>

    <?php if (!($post['image'] === NULL || $post['image'] === 'EMPTY')) : ?>

        <img src="/app/uploads/images/<?php echo $post['image']; ?>" class="postImage" alt="">

        <form action="app/posts/update.php?id=<?php echo $post['id']; ?>" method="post">
            <input type="hidden" name="deleteImage">
            <button>Delete image</button>

        </form>

    <?php else : ?>

        <form action="app/posts/update.php?id=<?php echo $post['id']; ?>" method="post" enctype="multipart/form-data">
            <label for="image">Post an image dawg?</label>
            <input type="file" name="image"><br>
            <button class="mediumButton" type="submit">Post image</button>
        </form>

    <?php endif; ?>



    <form action="app/posts/update.php?id=<?php echo $post['id']; ?>" method="post">
        <label for="content"></label><br>
        <textarea class="editPostText" name="content" cols="30" rows="5"><?php echo $post['content']; ?></textarea><br>
        <button class="mediumButton" type="submit">Update</button>
    </form>
</article>





<?php require __DIR__ . '/views/footer.php'; ?>