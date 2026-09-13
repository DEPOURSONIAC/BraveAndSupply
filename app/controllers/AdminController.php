<?php

/**
 * Display the admin dashboard.
 *
 * @return void
 */
function showAdmin(): void
{
    $stats = getAdminStats();
    $recent_orders = getRecentOrders();
    $revenue_data = getRevenueData();

    view('admin/dashboard', [
        'stats' => $stats,
        'recent_orders' => $recent_orders,
        'revenue_data' => $revenue_data
    ]);
}


/**
 * Display the admin users page.
 *
 * @return void
 */
function showAdminUsers(): void
{
    $users = getAllUsers();

    view('admin/users', [
        'users' => $users
    ]);
}


/**
 * Display the admin products page.
 *
 * @return void
 */
function showAdminProducts(): void
{
    $products = getAllProducts();

    view('admin/products', [
        'products' => $products
    ]);
}


/**
 * Display the admin orders page.
 *
 * @return void
 */
function showAdminOrders(): void
{
    $orders = getAllOrders();

    view('admin/orders', [
        'orders' => $orders
    ]);
}


/**
 * Display an admin order.
 *
 * @param int $id Order ID.
 *
 * @return void
 */
function showAdminOrder(int $id): void
{
    $order = getAdminOrderById($id);

    if (!$order) {
        http_response_code(404);
        exit('Commande introuvable.');
    }

    view('admin/order', [
        'order' => $order
    ]);
}