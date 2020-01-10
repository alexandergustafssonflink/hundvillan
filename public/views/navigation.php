<nav class="topmenu">
    <h1 class="logo">Hundvillan</h1>


</nav>


<nav class="navbar">

    <a href="/index.php"><img src="/assets/images/home.png" class="navIcon" alt="Home"></a>
    <?php if (isset($_SESSION['user'])) : ?>
        <a href="/myprofile.php"><img src="/assets/images/bulldog.png" class="navIcon" alt="bulldog"></a>
        <a href="/app/users/logout.php"><img src="/assets/images/logout.png" class="navIcon" alt="Log out"></a>
    <?php endif; ?>
</nav>