<?php

/**
 * Get statistics for the admin dashboard.
 *
 * @return array{
 *     users: int,
 *     products: int,
 *     orders: int,
 *     revenue: float
 * }
 */
function getAdminStats(): array
{
    $db = getPDO();

    $stats = [
        'users' => 0,
        'products' => 0,
        'orders' => 0,
        'revenue' => 0,
    ];

    try {
        $sql = "SELECT (SELECT COUNT(*) FROM users) AS users, (SELECT COUNT(*) FROM products) AS products,(SELECT COUNT(*) FROM orders) AS orders, (SELECT COALESCE(SUM(total_price), 0) FROM orders) AS revenue";

        $stmt = $db->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $stats = [
                'users' => (int) $result['users'],
                'products' => (int) $result['products'],
                'orders' => (int) $result['orders'],
                'revenue' => (float) $result['revenue'],
            ];
        }
    } catch (PDOException $e) {
        error_log(__FUNCTION__ . '(): ' . $e->getMessage());
    }

    return $stats;
}


/**
 * Get the most recent orders.
 *
 * @param int $limit Maximum number of orders to return.
 *
 * @return array
 */
function getRecentOrders(int $limit = 5): array
{
    $db = getPDO();

    $orders = [];

    try {
        $limit = max(1, min($limit, 20));

        $sql = "SELECT o.id, o.user_id, o.total_price, o.status, o.created_at, u.name AS user_name, u.email AS user_email FROM orders o INNER JOIN users u ON u.id = o.user_id ORDER BY o.created_at DESC LIMIT $limit";

        $stmt = $db->query($sql);

        if ($stmt) {
            $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    } catch (PDOException $e) {
        error_log(__FUNCTION__ . '(): ' . $e->getMessage());
    }

    return $orders;
}


/**
 * Get revenue data for all orders.
 *
 * @return array
 */
function getRevenueData(): array
{
    $db = getPDO();

    $revenue_data = [];

    try {
        $sql = "SELECT created_at, total_price FROM orders ORDER BY created_at ASC";

        $stmt = $db->query($sql);

        if ($stmt) {
            $revenue_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($revenue_data as &$row) {
                $row['total_price'] = (float) $row['total_price'];
            }

            unset($row);
        }
    } catch (PDOException $e) {
        error_log(__FUNCTION__ . '(): ' . $e->getMessage());
    }

    return $revenue_data;
}


/**
 * Get an order with its customer and product details.
 *
 * @param int $order_id The ID of the order.
 *
 * @return array{
 *     order: array,
 *     items: array
 * }|null
 */
function getAdminOrderById(int $order_id): ?array
{
    $db = getPDO();

    $order_details = null;

    try {
        if ($order_id > 0) {
            // Get the order with customer information.
            $sql = "SELECT o.id, o.user_id, o.total_price, o.status, o.created_at, u.name AS user_name, u.email AS user_email, u.address AS user_address FROM orders o INNER JOIN users u ON u.id = o.user_id WHERE o.id = ? LIMIT 1";

            $stmt = $db->prepare($sql);
            $stmt->execute([$order_id]);

            $order = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($order) {
                // Get the products included in the order.
                $sql = " SELECT oi.product_id, oi.quantity, oi.price, p.name, p.image FROM order_items oi INNER JOIN products p ON p.id = oi.product_id WHERE oi.order_id = ?";

                $stmt = $db->prepare($sql);
                $stmt->execute([$order_id]);

                $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $order_details = [
                    'order' => $order,
                    'items' => $items,
                ];
            }
        }
    } catch (PDOException $e) {
        error_log(__FUNCTION__ . '(): ' . $e->getMessage());
    }

    return $order_details;
}