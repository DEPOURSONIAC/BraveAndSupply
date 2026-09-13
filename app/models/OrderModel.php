<?php

/**
 * Create a new order for a user.
 *
 * @param int $user_id User ID.
 * @param float $total_price Order total price.
 * @param string $status Order status.
 *
 * @return int Order ID if created, otherwise 0.
 */
function createOrder(int $user_id, float $total_price, string $status = 'pending'): int
{
    $db = getPDO();
    $order_id = 0;

    try {
        if ($user_id > 0 && $total_price >= 0 && !empty($status)) {
            $sql = "INSERT INTO orders (user_id, total_price, status) VALUES (?, ?, ?)";

            $stmt = $db->prepare($sql);

            $created = $stmt->execute([$user_id, $total_price, $status]);

            if ($created) {
                $order_id = (int) $db->lastInsertId();
            }
        }
    } catch (PDOException $e) {
        error_log(__FUNCTION__ . '(): ' . $e->getMessage());
    }

    return $order_id;
}


/**
 * Add a product to an order.
 *
 * @param int $order_id Order ID.
 * @param int $product_id Product ID.
 * @param int $quantity Product quantity.
 * @param float $price Product price.
 *
 * @return bool True if the item was added successfully.
 */
function addOrderItem(int $order_id, int $product_id, int $quantity, float $price): bool
{
    $db = getPDO();
    $added = false;

    try {
        if ($order_id > 0 && $product_id > 0 && $quantity > 0 && $price >= 0) {
            $sql = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";

            $stmt = $db->prepare($sql);

            $added = $stmt->execute([$order_id, $product_id, $quantity, $price]);
        }
    } catch (PDOException $e) {
        error_log(__FUNCTION__ . '(): ' . $e->getMessage());
    }

    return $added;
}


/**
 * Create an order from the user's cart.
 *
 * Creates the order, adds its products, then clears the cart.
 *
 * @param int $user_id User ID.
 * @param string $status Order status.
 *
 * @return int|null Order ID if created, otherwise null.
 */
function createOrderFromCart(int $user_id, string $status = 'pending'): ?int
{
    $order_id = null;

    try {
        if ($user_id > 0) {
            $cart = getCart($user_id);

            if (!empty($cart['products'])) {
                $order_id = createOrder($user_id, $cart['total'], $status);

                if ($order_id > 0) {
                    foreach ($cart['products'] as $product) {
                        addOrderItem(
                            $order_id,
                            (int) $product['id'],
                            (int) $product['quantity'],
                            (float) $product['price']
                        );
                    }

                    clearCart($user_id);
                }
            }
        }
    } catch (PDOException $e) {
        error_log(__FUNCTION__ . '(): ' . $e->getMessage());
    }

    return $order_id;
}


/**
 * Get all orders.
 *
 * Mainly used for administration.
 *
 * @return array List of all orders.
 */
function getAllOrders(): array
{
    $db = getPDO();
    $orders = [];

    try {
        $sql = "SELECT * FROM orders ORDER BY id DESC";

        $stmt = $db->query($sql);

        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log(__FUNCTION__ . '(): ' . $e->getMessage());
    }

    return $orders;
}


/**
 * Get an order with its associated products.
 *
 * @param int $order_id Order ID.
 * @param int $user_id User ID.
 *
 * @return array|null Order details if found, otherwise null.
 */
function getOrderById(int $order_id, int $user_id): ?array
{
    $db = getPDO();
    $order_details = null;

    try {
        if ($order_id > 0 && $user_id > 0) {
            $sql = "SELECT * FROM orders WHERE id = ? AND user_id = ?";

            $stmt = $db->prepare($sql);
            $stmt->execute([$order_id, $user_id]);

            $order = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($order) {
                $sql = "SELECT oi.product_id, oi.quantity, oi.price, p.name, p.image FROM order_items oi INNER JOIN products p ON p.id = oi.product_id WHERE oi.order_id = ?";

                $stmt = $db->prepare($sql);
                $stmt->execute([$order_id]);

                $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $order_details = [
                    'order' => $order,
                    'items' => $items
                ];
            }
        }
    } catch (PDOException $e) {
        error_log(__FUNCTION__ . '(): ' . $e->getMessage());
    }

    return $order_details;
}


/**
 * Get all orders for a user.
 *
 * @param int $user_id User ID.
 *
 * @return array List of orders.
 */
function getOrdersByUser(int $user_id): array
{
    $db = getPDO();
    $orders = [];

    try {
        if ($user_id > 0) {
            $sql = "SELECT * FROM orders WHERE user_id = ? ORDER BY id DESC";

            $stmt = $db->prepare($sql);
            $stmt->execute([$user_id]);

            $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    } catch (PDOException $e) {
        error_log(__FUNCTION__ . '(): ' . $e->getMessage());
    }

    return $orders;
}


/**
 * Count the number of orders for a user.
 *
 * @param int $user_id User ID.
 *
 * @return int Number of orders.
 */
function countOrdersByUser(int $user_id): int
{
    $db = getPDO();
    $order_count = 0;

    try {
        if ($user_id > 0) {
            $sql = "SELECT COUNT(*) FROM orders WHERE user_id = ?";

            $stmt = $db->prepare($sql);
            $stmt->execute([$user_id]);

            $order_count = (int) $stmt->fetchColumn();
        }
    } catch (PDOException $e) {
        error_log(__FUNCTION__ . '(): ' . $e->getMessage());
    }

    return $order_count;
}