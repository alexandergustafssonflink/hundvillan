<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// In this file we login users.

if (isset($_POST['email'], $_POST['password'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    $statement = $pdo->prepare('SELECT * FROM users WHERE email = :email');

    $statement->bindParam(':email', $email, PDO::PARAM_STR);

    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if (!($email === $user['email'])) {
        die(var_dump("WRONG EMAIL"));
        redirect('/login.php');
    }
    if (password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;
        redirect(('/index.php'));
    } else {
        var_dump('WRONG password');
    }
}
