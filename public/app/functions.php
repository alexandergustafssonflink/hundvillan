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
