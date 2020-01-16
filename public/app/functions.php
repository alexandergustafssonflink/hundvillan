<?php

declare(strict_types=1);

if (!function_exists('redirect')) {
    /**
     * Redirect the user to given path.
     *
     * @param string $path
     *
     * @return void
     */
    function redirect(string $path)
    {
        header("Location: ${path}");
        exit;
    }
}
/**
 * Function that checks if a post has been liked. 
 *
 * @param integer $userId
 * @param integer $postId
 * @param pdo $pdo
 * @return boolean
 */
function hasBeenLiked($userId, $postId, $pdo)

{
    $sql = "SELECT * FROM post_likes WHERE post_id = :post_id AND user_id = :user_id";
    $statement = $pdo->prepare($sql);
    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $statement->bindParam(':post_id', $postId, PDO::PARAM_INT);
    $statement->bindParam(':user_id', $userId, PDO::PARAM_INT);

    $statement->execute();

    $likeByUser = $statement->fetchAll(PDO::FETCH_ASSOC);

    if ($likeByUser) {
        return true;
    } else {
        return false;
    }
}

/**
 * Function that fetches amount of likes
 *
 * @param integer $postId
 * @param pdo $pdo
 * @return void
 */
function getAmountOfLikes($postId, $pdo)
{
    $sql = "SELECT COUNT(user_id) FROM post_likes WHERE post_id = :post_id";
    $statement = $pdo->prepare($sql);
    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }
    $statement->bindParam(':post_id', $postId, PDO::PARAM_INT);
    $statement->execute();

    $amountOflikes = $statement->fetch()[0];

    return $amountOflikes;
}

/**
 * Gets search results.
 *
 * @param string $search
 *
 * @param PDO $pdo
 *
 * @return array
 */
function getSearchResult(string $search, PDO $pdo): array
{
    $userId = $_SESSION['user']['id'];
    $search = filter_var($_GET['search'], FILTER_SANITIZE_STRING);
    $statement = $pdo->prepare('SELECT name, id, avatar FROM users WHERE name LIKE :search AND id != :id');
    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }
    $search = '%' . $search . '%';
    $statement->bindParam(':search', $search, PDO::PARAM_STR);
    $statement->bindParam(':id', $userId, PDO::PARAM_INT);
    $statement->execute();
    $searchResults = $statement->fetchAll(PDO::FETCH_ASSOC);
    if (!$searchResults) {
        $_SESSION['errors'][] = "No users found";
        redirect('search.php');
    }
    return $searchResults;
}

/**
 * Checks if there is a following connection.
 *
 * @param int $followId
 *
 * @param PDO $pdo
 *
 * @return bool
 */
function isFollowing(int $followId, PDO $pdo): bool
{
    $userId = $_SESSION['user']['id'];
    $statement = $pdo->prepare('SELECT * FROM followers 
    WHERE user_id = :userId AND follow_id = :followId');
    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }
    $statement->bindParam(':userId', $userId, PDO::PARAM_INT);
    $statement->bindParam(':followId', $followId, PDO::PARAM_INT);
    $statement->execute();
    $isFollowing = $statement->fetchAll(PDO::FETCH_ASSOC);
    if ($isFollowing) {
        return true;
    }
    return false;
}
