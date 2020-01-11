<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

$user = $_SESSION['user'];

if (isset($_POST['content'])) {
    $content = trim(filter_var($_POST['content'], FILTER_SANITIZE_STRING));
    $id = $_GET['id'];

    $sql = 'UPDATE posts SET content = :content WHERE id = :id';


    $statement = $pdo->prepare($sql);
    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }


    $statement->bindParam(':content', $content, PDO::PARAM_STR);
    $statement->bindParam(':id', $_GET['id'], PDO::PARAM_INT);

    $statement->execute();

    redirect('/editpost.php?id=' . $_GET['id']);
}

if (isset($_POST['deleteImage'])) {
    $sql = 'UPDATE posts SET image = NULL WHERE id = :id';
    $statement = $pdo->prepare($sql);
    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }
    $statement->bindParam(':id', $_GET['id'], PDO::PARAM_INT);

    $statement->execute();
    redirect('/editpost.php?id=' . $_GET['id']);
}

if (isset($_FILES['image'])) {
    $image = $_FILES['image'];
    $destination = '/../uploads/images/';
    $fileName = $user['id'] . random_int(1, 999999) . '.jpeg';
    move_uploaded_file($image['tmp_name'], __DIR__ . $destination . $fileName);
    $avatarUrl = $destination . $fileName;
    $image['name'] = $fileName;
    $sql = 'UPDATE posts SET image = :image WHERE id = :id';

    $statement = $pdo->prepare($sql);
    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }
    $statement->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $statement->bindParam(':image', $image['name'], PDO::PARAM_STR);

    $statement->execute();

    redirect('/editpost.php?id=' . $_GET['id']);
}




/*if (isset($_POST['content']) || isset($_FILES['image'])) {
    $content = trim(filter_var($_POST['content'], FILTER_SANITIZE_STRING));
    $image = $_FILES['image'];
    $sql = 'UPDATE posts SET content = :content, WHERE id = :id';

    $statement = $pdo->prepare($sql);
    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $statement->bindParam(':content', $content, PDO::PARAM_STR);
    $statement->bindParam(':id', $_GET['id'], PDO::PARAM_INT);

    $statement->execute();
}


if (!($image['name'] === '')) {
    $destination = '/../uploads/images/';
    $fileName = $user['id'] . random_int(1, 999999) . '.jpeg';
    move_uploaded_file($image['tmp_name'], __DIR__ . $destination . $fileName);
    $avatarUrl = $destination . $fileName;
    $image['name'] = $fileName;
    $sql = 'UPDATE posts SET content = :content, image = :image WHERE id = :id';

    $statement = $pdo->prepare($sql);
    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $statement->bindParam(':content', $content, PDO::PARAM_STR);
    $statement->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $statement->bindParam(':image', $image['name'], PDO::PARAM_STR);

    $statement->execute();
} else {
    $sql = 'UPDATE posts SET content = :content WHERE id = :id';
    $statement = $pdo->prepare($sql);
    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $statement->bindParam(':content', $content, PDO::PARAM_STR);
    $statement->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $statement->execute();
} */



// redirect(('/index.php'));
