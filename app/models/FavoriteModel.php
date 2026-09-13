<?php

/**
 * Add a product to the user's favorites.
 *
 * @param int $user_id User ID.
 * @param int $product_id Product ID.
 *
 * @return bool True if the product was added successfully.
 */
function insertFavorite(int $user_id, int $product_id): bool
{
    $db = getPDO();
    $added = false;

    try {
        if ($user_id > 0 && $product_id > 0) {
            $sql = "SELECT 1 FROM favorites WHERE user_id = ? AND product_id = ? LIMIT 1";

            $stmt = $db->prepare($sql);
            $stmt->execute([$user_id, $product_id]);

            $exists = $stmt->fetch() !== false;

            if ($exists) {
                $added = true;
            } else {
                $sql = "INSERT INTO favorites (user_id, product_id) VALUES (?, ?)";

                $stmt = $db->prepare($sql);

                $added = $stmt->execute([$user_id, $product_id]);
            }
        }
    } catch (PDOException $e) {
        error_log(__FUNCTION__ . '(): ' . $e->getMessage());
    }

    return $added;
}


/**
 * Remove a product from the user's favorites.
 *
 * @param int $user_id User ID.
 * @param int $product_id Product ID.
 *
 * @return bool True if the product was removed successfully.
 */
function removeFavorite(int $user_id, int $product_id): bool
{
    $db = getPDO();
    $removed = false;

    try {
        if ($user_id > 0 && $product_id > 0) {
            $sql = "DELETE FROM favorites WHERE user_id = ? AND product_id = ?";

            $stmt = $db->prepare($sql);

            $removed = $stmt->execute([$user_id, $product_id]);
        }
    } catch (PDOException $e) {
        error_log(__FUNCTION__ . '(): ' . $e->getMessage());
    }

    return $removed;
}


/**
 * Get all favorite products for a user.
 *
 * @param int $user_id User ID.
 *
 * @return array List of favorite products.
 */
function getFavorites(int $user_id): array
{
    $db = getPDO();
    $favorites = [];

    try {
        if ($user_id > 0) {
            $sql = "SELECT p.* FROM favorites f INNER JOIN products p ON p.id = f.product_id WHERE f.user_id = ? ORDER BY f.id DESC";

            $stmt = $db->prepare($sql);
            $stmt->execute([$user_id]);

            $favorites = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    } catch (PDOException $e) {
        error_log(__FUNCTION__ . '(): ' . $e->getMessage());
    }

    return $favorites;
}


/**
 * Check if a product is in the user's favorites.
 *
 * @param int $user_id User ID.
 * @param int $product_id Product ID.
 *
 * @return bool True if the product is in the favorites.
 */
function isFavorite(int $user_id, int $product_id): bool
{
    $db = getPDO();
    $favorite = false;

    try {
        if ($user_id > 0 && $product_id > 0) {
            $sql = "SELECT 1 FROM favorites WHERE user_id = ? AND product_id = ? LIMIT 1";

            $stmt = $db->prepare($sql);
            $stmt->execute([$user_id, $product_id]);

            $favorite = $stmt->fetch() !== false;
        }
    } catch (PDOException $e) {
        error_log(__FUNCTION__ . '(): ' . $e->getMessage());
    }

    return $favorite;
}