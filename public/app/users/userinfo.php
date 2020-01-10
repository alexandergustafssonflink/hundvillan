<?php

declare(strict_types=1);

$statement = $pdo->prepare('SELECT * FROM users WHERE id = :id');
$statement->execute([
    ':id' => $_SESSION['user']['id']
]);

$user = $statement->fetch(PDO::FETCH_ASSOC);
