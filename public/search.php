 <?php
    require __DIR__ . '/views/header.php';
    if (isset($_SESSION['user'])) {
        $user = $_SESSION['user'];
    }
    ?>

 <article class="search">
     <?php if (isset($_SESSION['errors'])) : ?>
         <div class="errors">
             <?php foreach ($_SESSION['errors'] as $error) : ?>
                 <p><?= $error ?></p>
             <?php endforeach; ?>
             <?php unset($_SESSION['errors']); ?>
         </div>
     <?php endif; ?>

     <form action="search.php" method="get">
         <input type="text" name="search" placeholder="Name" value autocomplete="off" required>
         <button type="submit">Search</button>
     </form>

     <div class="searchResults">
         <?php if (isset($_GET['search'])) : ?>
             <?php $searchResults = getSearchResult($_GET['search'], $pdo) ?>
             <?php foreach ($searchResults as $searchResult) : ?>
                 <div class="searchResult">
                     <img src="app/uploads/avatars/<?=$searchResult['avatar']?>" alt="profile image">
                     <p><?= $searchResult['name'] ?></p>
                     <form action="/app/users/follow.php" method="post">
                         <input type="hidden" name="followId" value="<?=$searchResult['id']?>">
                         <button type="submit">
                             <?=isFollowing($searchResult['id'], $pdo) ? 'Unfollow' : 'Follow' ?>
                         </button>
                     </form>
                 </div>
             <?php endforeach; ?>
         <?php endif; ?>
     </div>
 </article>