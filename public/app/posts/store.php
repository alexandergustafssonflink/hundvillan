<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

$user = $_SESSION['user'];
$id = $user['id'];
$date = date('Y/m/d h:i:s a', time());

if (isset($_POST['content']) || isset($_FILES['image'])) {
    $content = trim(filter_var($_POST['content'], FILTER_SANITIZE_STRING));
    $image = $_FILES['image'];


    if (!($image['name'] == '')) {
        $destination = '/../uploads/images/';
        $fileName = $user['id'] . '-' .  random_int(1, 999999) . '.jpeg';
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
