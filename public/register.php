<?php require __DIR__ . '/views/header.php'; ?>

<?php

if (isset($_POST['email'], $_POST['name'], $_POST['password'])) {

    $name = trim((filter_var($_POST['name'], FILTER_SANITIZE_STRING)));
    $email = trim((filter_var($_POST['email'], FILTER_SANITIZE_EMAIL)));
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = 'INSERT INTO users (name, email, password) VALUES (:name, :email, :password)';

    $statement = $pdo->prepare($sql);

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $statement->bindParam(':name', $name, PDO::PARAM_STR);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':password', $password, PDO::PARAM_STR);

    $statement->execute();


    $statement = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);
    $_SESSION['user'] = $user;
    redirect(('/index.php'));
}

?>

<article>
    <h1>Registrera dig som användare mudda!</h1>

    <form action="register.php" method="post" enctype="multipart/form-data">
        <label for="email">Enter your email</label>
        <input type="text" name="email" id="email">
        <label for="password">Enter your password</label>
        <input type="password" name="password" id="password">
        <label for="name">Your name plixx</label>
        <input type="text" name="name" id="name">
        <button type="submit">SUBMIT!</button>
    </form>
</article>

<?php require __DIR__ . '/views/footer.php'; ?>