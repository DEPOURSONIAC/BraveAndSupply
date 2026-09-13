<?php

/**
 * Get the user's cart or create it if it does not exist.
 *
 * @param int $user_id User ID.
 *
 * @return int Cart ID, or 0 if the operation fails.
 */
function getOrCreateCart(int $user_id): int
{
    $db = getPDO();
    $cart_id = 0;

    try {
        $sql = "SELECT id FROM carts WHERE user_id = ? LIMIT 1";

        $stmt = $db->prepare($sql);
        $stmt->execute([$user_id]);

        $cart = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cart) {
            $cart_id = (int) $cart['id'];
        } else {
            $sql = "INSERT INTO carts (user_id) VALUES (?)";

            $stmt = $db->prepare($sql);
            $stmt->execute([$user_id]);

            $cart_id = (int) $db->lastInsertId();
        }
    } catch (PDOException $e) {
        error_log(__FUNCTION__ . '(): ' . $e->getMessage());
    }

    return $cart_id;
}


/**
 * Add a product to the user's cart.
 *
 * If the product is already in the cart, its quantity is increased.
 *
 * @param int $user_id User ID.
 * @param int $product_id Product ID.
 * @param int $quantity Quantity to add.
 *
 * @return bool True if the product was added successfully.
 */
function insertCartItem(int $user_id, int $product_id, int $quantity = 1): bool
{
    $db = getPDO();
    $added = false;

    try {
        if ($user_id > 0 && $product_id > 0 && $quantity > 0) {
            $cart_id = getOrCreateCart($user_id);

            if ($cart_id > 0) {
                $sql = "SELECT quantity FROM cart_items WHERE cart_id = ? AND product_id = ? LIMIT 1";

                $stmt = $db->prepare($sql);
                $stmt->execute([$cart_id, $product_id]);

                $item = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($item) {
                    $sql = "UPDATE cart_items SET quantity = quantity + ? WHERE cart_id = ? AND product_id = ?";

                    $stmt = $db->prepare($sql);

                    $added = $stmt->execute([
                        $quantity,
                        $cart_id,
                        $product_id,
                    ]);
                } else {
                    $sql = "INSERT INTO cart_items (cart_id, product_id, quantity) VALUES (?, ?, ?)";

                    $stmt = $db->prepare($sql);

                    $added = $stmt->execute([
                        $cart_id,
                        $product_id,
                        $quantity,
                    ]);
                }
            }
        }
    } catch (PDOException $e) {
        error_log(__FUNCTION__ . '(): ' . $e->getMessage());
    }

    return $added;
}


/**
 * Get the user's cart with its products and total price.
 *
 * @param int $user_id User ID.
 *
 * @return array{
 *     products: array,
 *     total: float
 * }
 */
function getCart(int $user_id): array
{
    $db = getPDO();

    $cart = [
        'products' => [],
        'total' => 0,
    ];

    try {
        if ($user_id > 0) {
            $sql = "SELECT id FROM carts WHERE user_id = ? LIMIT 1";

            $stmt = $db->prepare($sql);
            $stmt->execute([$user_id]);

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $sql = "SELECT p.id, ci.quantity, p.name, p.image, p.price, (p.price * ci.quantity) AS total_by_product
                    FROM cart_items ci
                    INNER JOIN products p ON p.id = ci.product_id
                    WHERE ci.cart_id = ?";

                $stmt = $db->prepare($sql);
                $stmt->execute([(int) $result['id']]);

                $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $total = 0;

                foreach ($products as $product) {
                    $total += (float) $product['total_by_product'];
                }

                $cart = [
                    'products' => $products,
                    'total' => $total,
                ];
            }
        }
    } catch (PDOException $e) {
        error_log(__FUNCTION__ . '(): ' . $e->getMessage());
    }

    return $cart;
}


/**
 * Delete a product from the user's cart.
 *
 * @param int $user_id User ID.
 * @param int $product_id Product ID.
 *
 * @return bool True if the product was deleted successfully.
 */
function deleteCartItem(int $user_id, int $product_id): bool
{
    $db = getPDO();
    $deleted = false;

    try {
        if ($user_id > 0 && $product_id > 0) {
            $sql = "DELETE FROM cart_items WHERE cart_id = (SELECT id FROM carts WHERE user_id = ?) AND product_id = ?";

            $stmt = $db->prepare($sql);

            $deleted = $stmt->execute([$user_id, $product_id]);
        }
    } catch (PDOException $e) {
        error_log(__FUNCTION__ . '(): ' . $e->getMessage());
    }

    return $deleted;
}


/**
 * Remove all products from the user's cart.
 *
 * @param int $user_id User ID.
 *
 * @return bool True if the cart was cleared successfully.
 */
function clearCart(int $user_id): bool
{
    $db = getPDO();
    $cleared = false;

    try {
        if ($user_id > 0) {
            $sql = "DELETE FROM cart_items WHERE cart_id = (SELECT id FROM carts WHERE user_id = ?)";

            $stmt = $db->prepare($sql);

            $cleared = $stmt->execute([$user_id]);
        }
    } catch (PDOException $e) {
        error_log(__FUNCTION__ . '(): ' . $e->getMessage());
    }

    return $cleared;
}


/**
 * Count the total quantity of products in the user's cart.
 *
 * @param int $user_id User ID.
 *
 * @return int Total number of products in the cart.
 */
function countProductInCartByUser(int $user_id): int
{
    $db = getPDO();
    $product_count = 0;

    try {
        if ($user_id > 0) {
            $sql = "SELECT COALESCE(SUM(cart_items.quantity), 0) FROM cart_items INNER JOIN carts ON cart_items.cart_id = carts.id WHERE carts.user_id = ?";

            $stmt = $db->prepare($sql);
            $stmt->execute([$user_id]);

            $product_count = (int) $stmt->fetchColumn();
        }
    } catch (PDOException $e) {
        error_log(__FUNCTION__ . '(): ' . $e->getMessage());
    }

    return $product_count;
}


/**
 * Update the quantity of a product in the user's cart.
 *
 * @param int $user_id User ID.
 * @param int $product_id Product ID.
 * @param int $quantity New quantity.
 *
 * @return bool True if the quantity was updated successfully.
 */
function updateCartItemQuantity(int $user_id, int $product_id, int $quantity): bool
{
    $db = getPDO();
    $updated = false;

    try {
        if ($user_id > 0 && $product_id > 0 && $quantity > 0) {
            $sql = "UPDATE cart_items SET quantity = ? WHERE cart_id = (SELECT id FROM carts WHERE user_id = ?) AND product_id = ?";

            $stmt = $db->prepare($sql);

            $updated = $stmt->execute([
                $quantity,
                $user_id,
                $product_id,
            ]);
        }
    } catch (PDOException $e) {
        error_log(__FUNCTION__ . '(): ' . $e->getMessage());
    }

    return $updated;
}
