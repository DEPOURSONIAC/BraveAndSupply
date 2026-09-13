<?php

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

function showAdminUsers(): void
{
    $users = getAllUsers();

    view('admin/users', [
        'users' => $users
    ]);
}

function showAdminProducts(): void
{
    $products = getAllProducts();

    view('admin/products', [
        'products' => $products
    ]);
}

function showAdminOrders(): void
{
    $orders = getAllOrders();

    view('admin/orders', [
        'orders' => $orders
    ]);
}

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
