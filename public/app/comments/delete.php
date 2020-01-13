<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // FETCHES COMMENT
    $statement = $pdo->prepare('SELECT * FROM post_comments WHERE id = :id');
    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();
    $comment = $statement->fetch();

    // DELETES COMMENT
    $sql = "DELETE from post_comments WHERE id = :id";
    $statement = $pdo->prepare($sql);
    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();
}

redirect('/post.php?id=' . $comment['post_id']);
