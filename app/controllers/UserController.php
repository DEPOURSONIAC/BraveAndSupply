<?php

function getCurrentUser(): array
{
    /*
        Récupère l'utilisateur actuellement connecté.

        Redirige vers la connexion si aucun utilisateur n'est connecté
        ou vers l'accueil si l'utilisateur n'existe plus en base de données.
    */

    if (!isset($_SESSION['id'])) {
        redirect('login');
    }

    $user = getUserById((int) $_SESSION['id']);

    if (!$user) {
        redirect('home');
    }

    return $user;
}

function getUserStats(int $user_id): array
{
    /*
        Récupère les statistiques de l'utilisateur.
    */

    return [
        'order_count'  => countOrdersByUser($user_id),
        'cart_count'   => countProductInCartByUser($user_id),
        'review_count' => countReviewsByUser($user_id),
    ];
}

// AJAX (pages dynamiques)

function showAccount(): void
{
    /*
        Affiche la page principale du compte utilisateur.

        Le profil est affiché par défaut.
        Les autres sections du compte peuvent ensuite être chargées
        dynamiquement via AJAX.
    */

    $user = getCurrentUser();
    $user_id = (int) $user['id'];

    $stats = getUserStats($user_id);
    $orders = getOrdersByUser($user_id);

    view('user/account', [
        'user'         => $user,
        'order_count'  => $stats['order_count'],
        'cart_count'   => $stats['cart_count'],
        'review_count' => $stats['review_count'],
        'order_last'   => $orders[0] ?? null,]);
}

function showProfile(): void
{
    /*
        Affiche uniquement le contenu du profil utilisateur.

        Cette vue est chargée dynamiquement via AJAX.
    */

    $user = getCurrentUser();
    $user_id = (int) $user['id'];

    $stats = getUserStats($user_id);
    $orders = getOrdersByUser($user_id);

    partial('user/account/profile', [
        'user'         => $user,
        'order_count'  => $stats['order_count'],
        'cart_count'   => $stats['cart_count'],
        'review_count' => $stats['review_count'],
        'order_last'   => $orders[0] ?? null,]);
}

function showOrders(): void
{
    /*
        Affiche les commandes de l'utilisateur.

        Cette section est destinée à être chargée dynamiquement
        depuis la page du compte.
    */

    $user = getCurrentUser();
    $user_id = (int) $user['id'];

    $stats = getUserStats($user_id);
    $orders = getOrdersByUser($user_id);

    partial('user/account/orders', [
        'order_count' => $stats['order_count'],
        'orders'      => $orders,
    ]);
}

function showReviews(): void
{
    /*
        Affiche les avis de l'utilisateur.

        Cette section est destinée à être chargée dynamiquement
        depuis la page du compte.
    */

    $user = getCurrentUser();
    $user_id = (int) $user['id'];

    $reviews = getReviewsByUser($user_id);

    partial('user/account/reviews', [
        'reviews' => $reviews,
    ]);
}