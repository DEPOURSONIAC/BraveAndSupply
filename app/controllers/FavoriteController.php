<?php

function showFavorite(): void
{
    /*
        Affiche les favoris de l'utilisateur.

        Cette section est destinée à être chargée dynamiquement(AJAX)
        depuis la page du compte.
    */

    $user = getCurrentUser();
    $user_id = (int) $user['id'];

    $favorites = getFavorites($user_id);

    partial('shop/favorites', [
        'favorites' => $favorites,
    ]);
}

function addToFavorite(int $product_id): void
{
    /*
        Ajoute un produit aux favoris
        de l'utilisateur connecté.
    */

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


function removeFromFavorite(int $product_id): void
{
    /*
        Retire un produit des favoris
        de l'utilisateur connecté.
    */

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
