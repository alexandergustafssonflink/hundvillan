<?php require __DIR__ . '/views/header.php'; ?>
<?php
$user = $_SESSION['user'];
$id = $user['id'];

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
}

?>

<article>
    <h1> Update your profile</h1>
    <h3>Username: <?php echo $user['name']; ?></h3>
    <h3>Email: <?php echo $user['email']; ?></h3>

    <h2>Update biography</h2>
    <form class="form-section" action="/myprofile.php" method="post">
        <label for="biography">Biography</label>
        <textarea name="biography" id="biography" cols="30" rows="10"><?php echo $user['biography']; ?></textarea>
        <button class="account-btn" type="submit">Update</button>
    </form>

    <img src="<?php echo $user['avatar_url']; ?>" alt="">

    <br>

    <form action="myprofile.php" method="post" enctype="multipart/form-data">
        <label for="avatar">Ladda upp en profilbildsjävel vettja?</label>
        <input type="file" name="avatar">
        <button type="submit"> Uppdatera din profilbildjävel. </button>

    </form>


</article>