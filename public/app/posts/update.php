<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';


$statement = $pdo->prepare('SELECT * FROM posts WHERE id = :id');
$statement->execute([
    ':id' => $_GET['id']
]);

$post = $statement->fetch(PDO::FETCH_ASSOC);



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

    $sql = 'UPDATE posts SET content = :content, image = :image WHERE id = :id';

    $statement = $pdo->prepare($sql);
    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $statement->bindParam(':content', $content, PDO::PARAM_STR);
    $statement->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $statement->bindParam(':image', $image['name'], PDO::PARAM_STR);

    $statement->execute();

    redirect(('/myprofile.php'));
}




// In this file we update posts in the database.

if (isset($_GET['id'])) : ?>
    <?php $id = $_GET['id'] ?>

    <form action="" method="post" enctype="multipart/form-data">

        <label for="content"></label>
        <textarea name="content" cols="30" rows="3">

        <?php echo $post['content']; ?>

</textarea>

        <label for="Image">Upload a new image breh?</label>
        <input type="file" name="image">
        <br>
        <?php if (!($post['image'] === NULL || $post['image'] === 'EMPTY')) : ?>

            <img src="/app/uploads/images/<?php echo $post['image']; ?>" class="postImage" alt="">

        <?php endif; ?>
        <br>

        <button type="submit">Post it dogg</button>

    </form>


<?php endif; ?>