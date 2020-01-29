<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['postId'])) {
    $postId = $_POST['postId'];
    $user = $_SESSION['user'];
    $userId = $user['id'];

    if (hasBeenLiked($userId, $postId, $pdo)) {
        $sql = "DELETE from post_likes WHERE post_id = :postId AND user_id = :userId";
        $statement = $pdo->prepare($sql);
        if (!$statement) {
            die(var_dump($pdo->errorInfo()));
        }
        $statement->bindParam(':userId', $user['id'], PDO::PARAM_INT);
        $statement->bindParam(':postId', $postId, PDO::PARAM_INT);

        $statement->execute();
        redirect(('/index.php'));
    } else {

        $sql = "INSERT INTO post_likes (user_id, post_id) VALUES (:userId, :postId)";
        $statement = $pdo->prepare($sql);
        if (!$statement) {
            die(var_dump($pdo->errorInfo()));
        }
        $statement->bindParam(':userId', $user['id'], PDO::PARAM_INT);
        $statement->bindParam(':postId', $postId, PDO::PARAM_INT);

        $statement->execute();

        redirect(('/index.php'));
    }
}
