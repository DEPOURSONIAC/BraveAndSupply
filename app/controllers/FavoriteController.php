<?php

/**
 * Display the user's favorite products.
 *
 * This section is loaded dynamically with AJAX
 * from the account page.
 *
 * @return void
 */
function showFavorite(): void
{
    $user = getCurrentUser();
    $user_id = (int) $user['id'];

    $favorites = getFavorites($user_id);

    partial('shop/favorites', [
        'favorites' => $favorites
    ]);
}


/**
 * Add a product to the user's favorites.
 *
 * @param int $product_id Product ID.
 *
 * @return void
 */
function addToFavorite(int $product_id): void
{
    $user = getCurrentUser();
    $user_id = (int) $user['id'];

    if ($product_id <= 0) {
        http_response_code(400);
        exit('Identifiant de produit invalide.');
    }

    $added = insertFavorite($user_id, $product_id);

    if (!$added) {
        http_response_code(500);
        exit("Impossible d'ajouter le produit aux favoris.");
    }

    redirect('account');
}


/**
 * Remove a product from the user's favorites.
 *
 * @param int $product_id Product ID.
 *
 * @return void
 */
function removeFromFavorite(int $product_id): void
{
    $user = getCurrentUser();
    $user_id = (int) $user['id'];

    $success = false;

    if ($product_id > 0) {
        $removed = removeFavorite($user_id, $product_id);

        if ($removed) {
            $success = true;
        }
    }

    header('Content-Type: application/json');

    echo json_encode([
        'success' => $success
    ]);
}