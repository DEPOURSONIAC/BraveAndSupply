<?php

/**
 * Add a product to a user's list.
 *
 * @param int $user_id User ID.
 * @param int $product_id Product ID.
 * @param int $list_id List ID.
 *
 * @return bool True if the product was added successfully.
 */
function insertProductInList(int $user_id, int $product_id, int $list_id): bool
{
    $db = getPDO();
    $added = false;

    try {
        if ($user_id > 0 && $product_id > 0 && $list_id > 0) {
            $sql = "SELECT 1 FROM product_lists WHERE id = ? AND user_id = ? LIMIT 1";

            $stmt = $db->prepare($sql);
            $stmt->execute([$list_id, $user_id]);

            $listExists = $stmt->fetch() !== false;

            if ($listExists) {
                $sql = "SELECT 1 FROM product_list_items WHERE list_id = ? AND product_id = ? LIMIT 1";

                $stmt = $db->prepare($sql);
                $stmt->execute([$list_id, $product_id]);

                $exists = $stmt->fetch() !== false;

                if ($exists) {
                    $added = true;
                } else {
                    $sql = "INSERT INTO product_list_items (product_id, list_id) VALUES (?, ?)";

                    $stmt = $db->prepare($sql);

                    $added = $stmt->execute([$product_id, $list_id]);
                }
            }
        }
    } catch (PDOException $e) {
        error_log(__FUNCTION__ . '(): ' . $e->getMessage());
    }

    return $added;
}


/**
 * Remove a product from a user's list.
 *
 * @param int $user_id User ID.
 * @param int $list_id List ID.
 * @param int $product_id Product ID.
 *
 * @return bool True if the product was removed successfully.
 */
function deleteProductFromList(int $user_id, int $list_id, int $product_id): bool
{
    $db = getPDO();
    $removed = false;

    try {
        if ($user_id > 0 && $list_id > 0 && $product_id > 0) {
            $sql = "DELETE FROM product_list_items WHERE list_id = ? AND product_id = ? AND list_id IN (SELECT id FROM product_lists WHERE id = ? AND user_id = ?)";

            $stmt = $db->prepare($sql);

            $removed = $stmt->execute([
                $list_id,
                $product_id,
                $list_id,
                $user_id,
            ]);
        }
    } catch (PDOException $e) {
        error_log(__FUNCTION__ . '(): ' . $e->getMessage());
    }

    return $removed;
}


/**
 * Create a new product list for a user.
 *
 * @param int $user_id User ID.
 * @param string $name List name.
 *
 * @return bool True if the list was created successfully.
 */
function insertList(int $user_id, string $name): bool
{
    $db = getPDO();
    $created = false;

    try {
        if ($user_id > 0 && !empty(trim($name))) {
            $name = trim($name);

            $sql = "INSERT INTO product_lists (user_id, name) VALUES (?, ?)";

            $stmt = $db->prepare($sql);

            $created = $stmt->execute([$user_id, $name]);
        }
    } catch (PDOException $e) {
        error_log(__FUNCTION__ . '(): ' . $e->getMessage());
    }

    return $created;
}


/**
 * Get all product lists for a user.
 *
 * @param int $user_id User ID.
 *
 * @return array List of product lists.
 */
function getLists(int $user_id): array
{
    $db = getPDO();
    $lists = [];

    try {
        if ($user_id > 0) {
            $sql = "SELECT * FROM product_lists WHERE user_id = ? ORDER BY id DESC";

            $stmt = $db->prepare($sql);
            $stmt->execute([$user_id]);

            $lists = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    } catch (PDOException $e) {
        error_log(__FUNCTION__ . '(): ' . $e->getMessage());
    }

    return $lists;
}


/**
 * Get all products from a user's list.
 *
 * @param int $user_id User ID.
 * @param int $list_id List ID.
 *
 * @return array List of products.
 */
function getProductList(int $user_id, int $list_id): array
{
    $db = getPDO();
    $products = [];

    try {
        if ($user_id > 0 && $list_id > 0) {
            $sql = "SELECT p.* FROM products p INNER JOIN product_list_items pli ON p.id = pli.product_id INNER JOIN product_lists pl ON pl.id = pli.list_id WHERE pli.list_id = ? AND pl.user_id = ? ORDER BY pli.id DESC";

            $stmt = $db->prepare($sql);
            $stmt->execute([$list_id, $user_id]);

            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    } catch (PDOException $e) {
        error_log(__FUNCTION__ . '(): ' . $e->getMessage());
    }

    return $products;
}


/**
 * Delete a product list.
 *
 * @param int $user_id User ID.
 * @param int $list_id List ID.
 *
 * @return bool True if the list was deleted successfully.
 */
function removeList(int $user_id, int $list_id): bool
{
    $db = getPDO();
    $deleted = false;

    try {
        if ($user_id > 0 && $list_id > 0) {
            $sql = "DELETE FROM product_lists WHERE user_id = ? AND id = ?";

            $stmt = $db->prepare($sql);

            $deleted = $stmt->execute([$user_id, $list_id]);
        }
    } catch (PDOException $e) {
        error_log(__FUNCTION__ . '(): ' . $e->getMessage());
    }

    return $deleted;
}
