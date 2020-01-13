<?php require __DIR__ . '/views/header.php'; ?>

<article class="main">
    <h1 class="header">Register as a user, puppy. </h1>

    <?php if (isset($_SESSION['error'])) : ?>
        <h1 class="error"> <?php echo $_SESSION['error']; ?> </h1>

    <?php endif; ?>

    <form action="app/users/register.php" method="post" enctype="multipart/form-data">
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