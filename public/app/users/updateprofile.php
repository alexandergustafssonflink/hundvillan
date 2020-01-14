<?php require __DIR__ . '/../../views/header.php';

$user = $_SESSION['user'];
$id = $user['id'];

if (isset($_POST['name'])) {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);

    $statement = $pdo->prepare('SELECT * FROM users WHERE id = :id');
    $statement->execute([
        ':id' => $_SESSION['user']['id']
    ]);
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    $storedName = $user['name'];

    $changeQuery = $pdo->prepare('UPDATE users SET name = :name WHERE id = :id');
    $changeQuery->execute([
        ':name' => $name,
        ':id' => $_SESSION['user']['id']
    ]);
    $user['name'] = $name;
    $_SESSION['message'] = "Your name has been updated. WOFF!";

    redirect('/updateprofile.php');
}

if (isset($_POST['email'])) {
    $email = trim(filter_var($_POST['email'], FILTER_SANITIZE_STRING));

    $changeQuery = $pdo->prepare('UPDATE users SET email = :email WHERE id = :id');
    $changeQuery->execute([
        ':email' => $email,
        ':id' => $_SESSION['user']['id']
    ]);
    $user['email'] = $email;
    $_SESSION['message'] = "Your email has been updated. WOFF!";
    redirect('/updateprofile.php');
}

if (isset($_FILES['avatar'])) {
    $avatar = $_FILES['avatar'];
    $avatarName = random_int(1, 999999) . '.jpeg';

    $destination = '/../uploads/avatars/';
    move_uploaded_file($avatar['tmp_name'], __DIR__ . $destination . $avatarName);

    $avatarUrl = $destination . $user['id'] . '.jpg';

    $sql = 'UPDATE users SET avatar = :avatar WHERE id = :userId';

    $statement = $pdo->prepare($sql);

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }
    $statement->bindParam(':avatar', $avatarName, PDO::PARAM_STR);
    $statement->bindParam(':userId', $user['id'], PDO::PARAM_INT);

    $statement->execute();

    $user['avatar'] = $avatarName;
    $_SESSION['message'] = "Your avatar has been updated. WOFF!";
    redirect('/updateprofile.php');
}


if (isset($_POST['biography'])) {
    $biography = trim(filter_var($_POST['biography'], FILTER_SANITIZE_STRING));

    $statement = $pdo->prepare('SELECT * FROM users WHERE id = :id');
    $statement->execute([
        ':id' => $_SESSION['user']['id']
    ]);
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    $storedBiography = $user['biography'];

    $changeQuery = $pdo->prepare('UPDATE users SET biography = :biography WHERE id = :id');
    $changeQuery->execute([
        ':biography' => $biography,
        ':id' => $_SESSION['user']['id']
    ]);

    $_SESSION['message'] = "Your biography has been updated. WOFF!";

    redirect('/updateprofile.php');
}

if (isset($_POST['oldpassword'], $_POST['newpassword'], $_POST['confirmpassword'])) {
    $oldPassword = $_POST['oldpassword'];
    $newPassword = $_POST['newpassword'];
    $confirmPassword = $_POST['confirmpassword'];

    $statement = $pdo->prepare('SELECT * FROM users WHERE id = :id');
    $statement->execute([
        ':id' => $_SESSION['user']['id']
    ]);
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    $storedPassword = $user['password'];

    if (password_verify($oldPassword, $storedPassword) && $newPassword === $confirmPassword) {
        $changeQuery = $pdo->prepare('UPDATE users SET password = :newpassword WHERE id = :id');
        $changeQuery->execute([
            ':newpassword' => password_hash($newPassword, PASSWORD_DEFAULT),
            ':id' => $user['id']
        ]);
        $_SESSION['message'] = "Your password was successfully updated!";
    } else {
        $_SESSION['message'] = "Sorry, didn't work. Try again dawg.";
    }
    redirect('/updateprofile.php');
}
