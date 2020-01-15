<?php

declare(strict_types=1);
require __DIR__ . '/views/header.php';
require __DIR__ . '/app/users/userinfo.php';

$id = $user['id'];

?>

<article class="main">
    <h1> Settings </h1>

    <?php if (isset($_SESSION['message'])) : ?>
        <h3 class="updateProfileMessage"><?php echo $_SESSION['message']; ?></h3>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>
    <!-- UPDATE NAME SECTION -->
    <form action="app/users/updateprofile.php" method="post">
        <div class="updateForm">
            <div>
                <label for="name">Name</label>
                <input name="name" id="name" value="<?php echo $user['name']; ?>">
            </div>
            <button class="mediumButton" type="submit">Update</button>
        </div>
    </form>

    <!-- UPDATE EMAIL SECTION -->
    <form action="app/users/updateprofile.php" method="post">
        <div class="updateForm">
            <div>
                <label for="email">Email</label>
                <input name="email" class="emailUpdateInput" id="email" value="<?php echo $user['email']; ?>">
            </div>
            <button class="mediumButton" type="submit">Update</button>
        </div>
    </form>

    <!-- UPDATE BIOGRAPHY SECTION -->
    <form action="app/users/updateprofile.php" method="post" class="editBiography">
        <label for="biography">Biography</label><br>
        <textarea name="biography" class="updateBiography" id="biography" cols="30" rows="10"><?php echo $user['biography']; ?></textarea>
        <button class="mediumButton" type="submit">Update</button>
    </form>

    <!-- UPDATE AVATAR SECTION -->
    <form action="/app/users/updateprofile.php" method="post" enctype="multipart/form-data" class="editAvatar">
        <label for="avatar">Change avatar?</label>
        <input type="file" name="avatar">
        <button class="formButton" type="submit"> Change your avatar </button>
    </form>

    <!-- UPDATE PASSWORD SECTION -->
    <div class="editPasswordSection">

        <h3>Update password</h3>

        <form action="/app/users/updateprofile.php" method="post" enctype="multipart/form-data">
            <label for="oldpassword">Old password</label>
            <input name="oldpassword" type="password"><br>
            <label for="newpassword">New password</label>
            <input name="newpassword" type="password"><br>
            <label for="confirmpassword">Confirm new password</label>
            <input name="confirmpassword" type="password">
            <button class="formButton" type="submit"> Change password, doggy</button>
        </form>
    </div>

    <?php require __DIR__ . '/views/footer.php'; ?>