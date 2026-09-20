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

    $order_info = $order['order'] ?? [];
    $items = $order['items'] ?? [];
    $status = $order_info['status'] ?? 'pending';

    view('admin/order', [
        'order_info' => $order_info,
        'items' => $items,
        'status' => $status,
    ]);
}


/**d
 * Add a new product.
 *
 * @param string $name Product name.
 * @param string $description Product description.
 * @param float $price Product price.
 * @param int $quantity Product quantity.
 *
 * @return void
 */
function adminAddProduct(string $name, string $description, float $price, int $quantity = 1): void 
{
    // Validation
    $name = trim($name);
    $description = trim($description);

    if ($name === '') {
        http_response_code(400);
        exit('Le nom du produit est obligatoire.');
    }

    if ($price < 0) {
        http_response_code(400);
        exit('Le prix doit être positif.');
    }

    if ($quantity < 0) {
        http_response_code(400);
        exit('La quantité doit être positive.');
    }

    // Category and img doesn't work
    $created = createProduct(5, $name, $description, $price, $quantity, 'unkown.jpg');

    if (!$created) {
    http_response_code(500);
    exit('Impossible de créer le produit.');
    }

    redirect('adminProducts');
}


/**
 * Edit an existing product.
 *
 * @param int $id Product ID.
 * @param string $name Product name.
 * @param string $description Product description.
 * @param float $price Product price.
 * @param int $quantity Product quantity.
 *
 * @return void
 */
function adminEditProduct(int $id, string $name, string $description, float $price, int $quantity = 1): void 
{
    $name = trim($name);
    $description = trim($description);

    if ($id <= 0) {
        http_response_code(400);
        exit('Produit invalide.');
    }

    if ($name === '') {
        http_response_code(400);
        exit('Le nom du produit est obligatoire.');
    }

    if ($price < 0) {
        http_response_code(400);
        exit('Le prix doit être positif.');
    }

    if ($quantity < 0) {
        http_response_code(400);
        exit('La quantité doit être positive.');
    }

    $product = getProductById($id);

    if (!$product) {
        http_response_code(404);
        exit('Produit introuvable.');
    }

    // Category and img doesn't work
    $updated = updateProduct($id, 5, $name, $description, $price, $quantity, 'unkown.jpg');

    if (!$updated) {
    http_response_code(500);
    exit('Impossible de modifier le produit.');
    }

    redirect('adminProducts');
}


/**
 * Delete a product.
 *
 * @param int $id Product ID.
 *
 * @return void
 */
function adminDeleteProduct(int $id): void
{
    if ($id <= 0) {
        http_response_code(400);
        exit('Produit invalide.');
    }

    $product = getProductById($id);

    if (!$product) {
        http_response_code(404);
        exit('Produit introuvable.');
    }

    deleteProduct($id);

    redirect('adminProducts');
}


/**
 * Delete a user.
 *
 * @param int $id User ID.
 *
 * @return void
 */
function adminDeleteUser(int $id): void
{
    if ($id <= 0) {
        http_response_code(400);
        exit('Utilisateur invalide.');
    }

    $user = getUserById($id);

    if (!$user) {
        http_response_code(404);
        exit('Utilisateur introuvable.');
    }

    deleteUser($id);

    redirect('adminUsers');
}


/**
 * Mark an order as received.
 *
 * @param int $id Order ID.
 *
 * @return void
 */
function adminMarkOrderReceived(int $id): void
{
    if ($id <= 0) {
        http_response_code(400);
        exit('Commande invalide.');
    }

    $order = getAdminOrderById($id);

    if (!$order) {
        http_response_code(404);
        exit('Commande introuvable.');
    }

    markOrderReceived($id);

    redirect('admin');
}