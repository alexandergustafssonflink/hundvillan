<?php require __DIR__ . '/views/header.php'; ?>
<?php
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
}

if (isset($_POST['email'])) {
    $email = trim(filter_var($_POST['email'], FILTER_SANITIZE_STRING));

    $statement = $pdo->prepare('SELECT * FROM users WHERE id = :id');
    $statement->execute([
        ':id' => $_SESSION['user']['id']
    ]);
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    $storedName = $user['email'];

    $changeQuery = $pdo->prepare('UPDATE users SET email = :email WHERE id = :id');
    $changeQuery->execute([
        ':name' => $email,
        ':id' => $_SESSION['user']['id']
    ]);
    $user['email'] = $email;
}

if (isset($_FILES['avatar'])) {
    $avatar = $_FILES['avatar'];

    $destination = '/app/uploads/avatars/';
    move_uploaded_file($avatar['tmp_name'], __DIR__ . $destination . $user['id'] . '.jpg');
    $avatarUrl = $destination . $user['id'] . '.jpg';

    $sql = 'UPDATE users SET avatar_url = :avatarUrl WHERE id = :userId';


    $statement = $pdo->prepare($sql);

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }
    $statement->bindParam(':avatarUrl', $avatarUrl, PDO::PARAM_STR);
    $statement->bindParam(':userId', $user['id'], PDO::PARAM_INT);

    $statement->execute();

    $user['avatar'] = $avatarUrl;
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
    $user['biography'] = $biography;

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
        echo "Your password was succesfully updated";
    } else {
        echo "no match.";
    }
}

?>


<article>

    <h2>Update biography</h2>
    <form action="/updateprofile.php" method="post">
        <label for="name">Name</label>
        <input name="name" id="name" placeholder="<?php echo $user['name']; ?>"></textarea><br>
        <label for="email">Email</label>
        <input name="email" id="email" placeholder="<?php echo $user['email']; ?>"></textarea><br>

        <label for="biography">Biography</label><br>
        <textarea name="biography" id="biography" cols="30" rows="10"><?php echo $user['biography']; ?></textarea>


        <button type="submit">Update</button>
    </form>

    <br>
    <br>

    <form action="/updateprofile.php" method="post" enctype="multipart/form-data">
        <label for="avatar">Ladda upp en profilbildsjävel vettja?</label>
        <input type="file" name="avatar">
        <button type="submit"> Uppdatera din profilbildjävel. </button>
    </form>


    <h3>Update password</h3>

    <form action="/updateprofile.php" method="post" enctype="multipart/form-data">
        <label for="oldpassword">Old password</label>
        <input name="oldpassword" type="password">
        <label for="newpassword">New password</label>
        <input name="newpassword" type="password">
        <label for="confirmpassword">Confirm new password</label>
        <input name="confirmpassword" type="password">

        <button type="submit"> Change password breddah. </button>
    </form>





    <?php require __DIR__ . '/views/footer.php'; ?>