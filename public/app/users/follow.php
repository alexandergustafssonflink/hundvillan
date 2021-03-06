<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['followId'], $_POST['searchString'])) {
    $userId = (int) $_SESSION['user']['id'];
    $followId = (int) $_POST['followId'];

    if (!isFollowing($followId, $pdo)) {
        $query = 'INSERT INTO followers (user_id, follow_id)
        VALUES (:userId, :followId)';
        $statement = $pdo->prepare($query);
        $statement->execute([
            ':userId' => $userId,
            ':followId' => $followId
        ]);
    } else {
        $query = 'DELETE FROM followers
            WHERE user_id = :userId AND follow_id = :followId';
        $statement = $pdo->prepare($query);
        $statement->execute([
            ':userId' => $userId,
            ':followId' => $followId
        ]);
    }
}
redirect('/search.php?search='.$_POST['searchString']);
