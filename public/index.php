<?php require __DIR__ . '/views/header.php'; ?>

<?php

$statement = $pdo->prepare('SELECT * FROM posts');
$statement->execute();
$posts = $statement->fetchAll(PDO::FETCH_ASSOC);
$user = $_SESSION['user'];

?>

<article>
    <h1><?php echo $config['title']; ?></h1>
    <?php if (isset($_SESSION['user'])) : ?>
        <h1> Welcome back <?php echo $_SESSION['user']['name']; ?> </h1>

        <h3> Latest posts </h3>
        <?php
            foreach ($posts as $post) : ?>
            <h8><?php echo $post['date']; ?></h8><br>
            <h7><?php echo $post['content']; ?></h7>
            <br><br>

            <?php if ($user['id'] === $post['author_id']) : ?>

                <form action="/app/posts/delete.php?id=<?php echo $post['id']; ?>" method="post">
                    <button>Delete post</button>
                </form>

                <form action="/app/posts/update.php?id=<?php echo $post['id']; ?>" method="post">
                    <button>Edit post</button>
                </form>

            <?php endif; ?>

        <?php endforeach; ?>

    <?php endif; ?>

</article>





<?php require __DIR__ . '/views/footer.php'; ?>