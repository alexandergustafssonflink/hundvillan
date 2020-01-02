<?php require __DIR__ . '/views/header.php'; ?>
<?php

$user = $_SESSION['user'];
$id = $user['id'];
$date = date('m/d/Y h:i:s a', time());


$statement = $pdo->prepare('SELECT * FROM users WHERE id = :id');
$statement->execute([
    ':id' => $_SESSION['user']['id']
]);
$user = $statement->fetch(PDO::FETCH_ASSOC);


$statement = $pdo->prepare('SELECT * FROM posts WHERE author_id = :id');
$statement->execute([
    ':id' => $_SESSION['user']['id']
]);

$userPosts = $statement->fetchAll(PDO::FETCH_ASSOC);




if (isset($_POST['content']) || isset($_FILES['image'])) {
    $content = trim(filter_var($_POST['content'], FILTER_SANITIZE_STRING));
    $image = $_FILES['image'];

    if (!($image['name'] == '')) {
        $destination = '/app/uploads/images/';
        $fileName = $user['id'] . random_int(1, 999999) . '.jpeg';
        move_uploaded_file($image['tmp_name'], __DIR__ . $destination . $fileName);
        $avatarUrl = $destination . $fileName;
        $image['name'] = $fileName;
    } else {
        $image['name'] = NULL;
    }



    $sql = 'INSERT INTO posts (content, author_id, date, image) VALUES (:content, :id, :date, :image)';

    $statement = $pdo->prepare($sql);
    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $statement->bindParam(':content', $content, PDO::PARAM_STR);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->bindParam(':date', $date, PDO::PARAM_STR);
    $statement->bindParam(':image', $image['name'], PDO::PARAM_STR);

    $statement->execute();

    redirect(('/myprofile.php'));
}



?>

<article>
    <h1>My profile</h1>
    <img class="profileAvatar" src="<?php echo $user['avatar_url']; ?>" alt="">
    <h3>Username: <?php echo $user['name']; ?></h3>
    <h3>Email: <?php echo $user['email']; ?></h3>
    <h3>Biography: <?php echo $user['biography']; ?></h3>



    <a href="/updateprofile.php">
        <h6> Care to change your details? </h4>
    </a>

    <h5>Latest posts by you</h5>

    <?php foreach ($userPosts as $post) : ?>
        <h8><?php echo $post['date']; ?></h8>
        <br>
        <h7><?php echo $post['content']; ?></h7>
        <br>

        <?php if (!($post['image'] === NULL || $post['image'] === 'EMPTY')) : ?>

            <img src="/app/uploads/images/<?php echo $post['image']; ?>" class="postImage" alt="">

        <?php endif; ?>
        <br>

        <?php if ($user['id'] = $post['author_id']) : ?>

            <form action="/app/posts/delete.php?id=<?php echo $post['id']; ?>" method="post">
                <button>Delete post</button>
            </form>

            <form action="/app/posts/update.php?id=<?php echo $post['id']; ?>" method="post">
                <button>Edit post</button>
            </form>

        <?php endif; ?>

        <br><br><br>



    <?php endforeach; ?>

    <h4>Care to tell the world somethin, doogy? </h4>

    <form action="/myprofile.php" method="post" enctype="multipart/form-data">

        <label for="content"></label>
        <textarea name="content" cols="30" rows="3">
        </textarea>
        <br>

        <label for="Image">Upload an image breh?</label>
        <input type="file" name="image">
        <br>


        <button type="submit">Post it dogg</button>

    </form>





</article> <?php require __DIR__ . '/views/footer.php'; ?>