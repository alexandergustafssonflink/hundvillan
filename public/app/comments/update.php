<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

$user = $_SESSION['user'];

if (isset($_POST['content'])) {
    $content = trim(filter_var($_POST['content'], FILTER_SANITIZE_STRING));
    $id = $_GET['id'];

    $sql = 'UPDATE post_comments SET content = :content WHERE id = :id';
    $statement = $pdo->prepare($sql);
    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }
    $statement->bindParam(':content', $content, PDO::PARAM_STR);
    $statement->bindParam(':id', $_GET['id'], PDO::PARAM_INT);

    $statement->execute();


    // FETCHES COMMENT
    $statement = $pdo->prepare('SELECT * FROM post_comments WHERE id = :id');
    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();
    $comment = $statement->fetch();

    redirect('/post.php?id=' . $comment['post_id']);
}
