<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_GET['id'])) {
    $sql = "DELETE from posts WHERE id = :id";
    $statement = $pdo->prepare($sql);
    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }
    $statement->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $statement->execute();
}

redirect('/myprofile.php');
