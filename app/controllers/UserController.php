<?php

/**
 * Get the currently logged-in user.
 *
 * Redirects to the login page if no user is logged in.
 * Redirects to the home page if the user no longer exists.
 *
 * @return array Current user data.
 */
function getCurrentUser(): array
{
    if (!isset($_SESSION['id'])) {
        redirect('login');
    }

    $user = getUserById((int) $_SESSION['id']);

    if (!$user) {
        redirect('home');
    }

    return $user;
}


/**
 * Get statistics for a user.
 *
 * @param int $user_id User ID.
 *
 * @return array User statistics.
 */
function getUserStats(int $user_id): array
{
    return [
        'order_count'  => countOrdersByUser($user_id),
        'cart_count'   => countProductInCartByUser($user_id),
        'review_count' => countReviewsByUser($user_id)
    ];
}


/**
 * Display the main user account page.
 *
 * The profile is displayed by default.
 * Other sections can be loaded dynamically with AJAX.
 *
 * @return void
 */
function showAccount(): void
{
    $user = getCurrentUser();
    $user_id = (int) $user['id'];

    $stats = getUserStats($user_id);
    $orders = getOrdersByUser($user_id);

    view('user/account', [
        'user'         => $user,
        'order_count'  => $stats['order_count'],
        'cart_count'   => $stats['cart_count'],
        'review_count' => $stats['review_count'],
        'order_last'   => $orders[0] ?? null
    ]);
}


/**
 * Display the user's profile section.
 *
 * This section is loaded dynamically with AJAX.
 *
 * @return void
 */
function showProfile(): void
{
    $user = getCurrentUser();
    $user_id = (int) $user['id'];

    $stats = getUserStats($user_id);
    $orders = getOrdersByUser($user_id);

    partial('user/account/profile', [
        'user'         => $user,
        'order_count'  => $stats['order_count'],
        'cart_count'   => $stats['cart_count'],
        'review_count' => $stats['review_count'],
        'order_last'   => $orders[0] ?? null
    ]);
}


/**
 * Display the user's orders.
 *
 * This section is loaded dynamically with AJAX.
 *
 * @return void
 */
function showOrders(): void
{
    $user = getCurrentUser();
    $user_id = (int) $user['id'];

    $stats = getUserStats($user_id);
    $orders = getOrdersByUser($user_id);

    partial('user/account/orders', [
        'order_count' => $stats['order_count'],
        'orders'      => $orders
    ]);
}


/**
 * Display the user's reviews.
 *
 * This section is loaded dynamically with AJAX.
 *
 * @return void
 */
function showReviews(): void
{
    $user = getCurrentUser();
    $user_id = (int) $user['id'];

    $reviews = getReviewsByUser($user_id);

    partial('user/account/reviews', [
        'reviews' => $reviews
    ]);
}
