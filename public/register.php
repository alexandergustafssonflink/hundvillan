<?php require __DIR__ . '/views/header.php'; ?>

<?php

if (isset($_POST['email'], $_POST['name'], $_POST['password'])) {

    $name = trim((filter_var($_POST['name'], FILTER_SANITIZE_STRING)));
    $email = trim((filter_var($_POST['email'], FILTER_SANITIZE_EMAIL)));
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $defaultAvatar = 'bulldogavatar.png';

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


    $statement = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);
    $_SESSION['user'] = $user;
    redirect(('/index.php'));
}

?>

<article class="main">
    <h1 class="header">Register as a user, puppy. </h1>

    <form action="register.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="email">Enter your email</label>
            <input type="text" name="email" id="email">
        </div>
        <div class="form-group">
            <label for="password">Enter your password</label>
            <input type="password" name="password" id="password">
        </div>
        <div class="form-group">
            <label for="name">Your name please</label>
            <input type="text" name="name" id="name">
        </div>
        <button class="mainButton" type="submit">Register</button>
    </form>
</article>

<?php require __DIR__ . '/views/footer.php'; ?>