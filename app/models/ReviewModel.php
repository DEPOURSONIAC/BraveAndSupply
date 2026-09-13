<?php

/**
 * Add a review.
 *
 * @param int $user_id User ID.
 * @param string $comment Review comment.
 *
 * @return bool True if the review was added successfully.
 */
function addReview(int $user_id, string $comment): bool
{
    $db = getPDO();
    $added = false;

    try {
        if ($user_id > 0 && !empty($comment)) {
            $sql = "INSERT INTO reviews (user_id, comment) VALUES (?, ?)";

            $stmt = $db->prepare($sql);

            $added = $stmt->execute([$user_id, $comment]);
        }
    } catch (PDOException $e) {
        error_log(__FUNCTION__ . '(): ' . $e->getMessage());
    }

    return $added;
}


/**
 * Delete a review.
 *
 * Only the author can delete their own review.
 *
 * @param int $review_id Review ID.
 * @param int $user_id User ID.
 *
 * @return bool True if the review was deleted successfully.
 */
function deleteReview(int $review_id, int $user_id): bool
{
    $db = getPDO();
    $deleted = false;

    try {
        if ($review_id > 0 && $user_id > 0) {
            $sql = "DELETE FROM reviews WHERE id = ? AND user_id = ?";

            $stmt = $db->prepare($sql);

            $deleted = $stmt->execute([$review_id, $user_id]);
        }
    } catch (PDOException $e) {
        error_log(__FUNCTION__ . '(): ' . $e->getMessage());
    }

    return $deleted;
}


/**
 * Get all reviews.
 *
 * @return array List of all reviews.
 */
function getAllReviews(): array
{
    $db = getPDO();
    $reviews = [];

    try {
        $sql = "SELECT r.*, u.name FROM reviews r INNER JOIN users u ON u.id = r.user_id ORDER BY r.created_at DESC";

        $stmt = $db->query($sql);

        $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log(__FUNCTION__ . '(): ' . $e->getMessage());
    }

    return $reviews;
}


/**
 * Get all reviews from a user.
 *
 * Used for the user's account.
 *
 * @param int $user_id User ID.
 *
 * @return array List of reviews.
 */
function getReviewsByUser(int $user_id): array
{
    $db = getPDO();
    $reviews = [];

    try {
        if ($user_id > 0) {
            $sql = "SELECT * FROM reviews WHERE user_id = ? ORDER BY id DESC";

            $stmt = $db->prepare($sql);
            $stmt->execute([$user_id]);

            $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    } catch (PDOException $e) {
        error_log(__FUNCTION__ . '(): ' . $e->getMessage());
    }

    return $reviews;
}


/**
 * Count the number of reviews from a user.
 *
 * @param int $user_id User ID.
 *
 * @return int Number of reviews.
 */
function countReviewsByUser(int $user_id): int
{
    $db = getPDO();
    $review_count = 0;

    try {
        if ($user_id > 0) {
            $sql = "SELECT COUNT(*) FROM reviews WHERE user_id = ?";

            $stmt = $db->prepare($sql);
            $stmt->execute([$user_id]);

            $review_count = (int) $stmt->fetchColumn();
        }
    } catch (PDOException $e) {
        error_log(__FUNCTION__ . '(): ' . $e->getMessage());
    }

    return $review_count;
}