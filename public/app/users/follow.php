<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['followId'])) {
    $userId = (int) $_SESSION['user']['id'];
    $followId = (int) $_POST['followId'];
    $query = 'INSERT INTO followers (user_id, follow_id)
        VALUES (:userId, :followId)';
    $statement = $pdo->prepare($query);

    $statement->execute([
        ':userId' => $userId,
        ':followId' => $followId
    ]);
}
redirect('/search.php');