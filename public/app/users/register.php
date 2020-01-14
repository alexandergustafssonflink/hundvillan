<?php

declare(strict_types=1);

require __DIR__ . '/../../views/header.php';

if (isset($_POST['email'], $_POST['name'], $_POST['password'])) {

    $name = trim((filter_var($_POST['name'], FILTER_SANITIZE_STRING)));
    $email = trim((filter_var($_POST['email'], FILTER_SANITIZE_EMAIL)));
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $defaultAvatar = 'bulldogavatar.png';


    // CHECK IF EMAIL EXISTS
    $getEmailQuery = "SELECT * FROM users WHERE email = :email";
    $statement = $pdo->prepare($getEmailQuery);
    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->execute();

    $storedUser = $statement->fetch(PDO::FETCH_ASSOC);
    if ($storedUser['email'] == $email) {
        $_SESSION['error'] = 'The email adress you entered already exist, puppy.';
        redirect('/register.php');
    } else {
        // INSERT USER INTO DATABASE
        $sql = 'INSERT INTO users (name, email, password, avatar) VALUES (:name, :email, :password, :avatar)';

        $statement = $pdo->prepare($sql);

        if (!$statement) {
            die(var_dump($pdo->errorInfo()));
        }

        $statement->bindParam(':name', $name, PDO::PARAM_STR);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':password', $password, PDO::PARAM_STR);
        $statement->bindParam(':avatar', $defaultAvatar, PDO::PARAM_STR);

        $statement->execute();

        // LOG IN USER ON REGISTRATION
        $statement = $pdo->prepare('SELECT * FROM users WHERE email = :email');
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        $_SESSION['user'] = $user;
        redirect(('/index.php'));
    }
}
