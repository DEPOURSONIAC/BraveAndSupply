<?php

/**
 * Display the user's lists.
 *
 * This section is loaded dynamically with AJAX
 * from the account page.
 *
 * @return void
 */
function showLists(): void
{
    $user = getCurrentUser();
    $user_id = (int) $user['id'];

    $lists = getLists($user_id);

    view('user/account/lists', [
        'lists' => $lists
    ]);
}


/**
 * Display the products from a user's list.
 *
 * @param int $list_id List ID.
 *
 * @return void
 */
function showList(int $list_id): void
{
    $user = getCurrentUser();
    $user_id = (int) $user['id'];

    if ($list_id <= 0) {
        http_response_code(400);
        exit('Identifiant de liste invalide.');
    }

    $products = getProductList($user_id, $list_id);

    view('user/account/list', [
        'products' => $products,
        'list_id' => $list_id
    ]);
}


/**
 * Create a new list for the current user.
 *
 * @param string $name List name.
 *
 * @return void
 */
function createList(string $name): void
{
    $user = getCurrentUser();
    $user_id = (int) $user['id'];

    $name = trim($name);
    $success = false;

    if ($name !== '') {
        $created = insertList($user_id, $name);

        if ($created) {
            $success = true;
        }
    }

    header('Content-Type: application/json');

    echo json_encode(['success' => $success]);
}


/**
 * Delete a list from the current user's account.
 *
 * @param int $list_id List ID.
 *
 * @return void
 */
function deleteList(int $list_id): void
{
    $user = getCurrentUser();
    $user_id = (int) $user['id'];

    $success = false;

    if ($list_id > 0) {
        $deleted = removeList($user_id, $list_id);

        if ($deleted) {
            $success = true;
        }
    }

    header('Content-Type: application/json');

    echo json_encode(['success' => $success]);
}


/**
 * Add a product to a user's list.
 *
 * @param int $product_id Product ID.
 * @param int $list_id List ID.
 *
 * @return void
 */
function addToList(int $product_id, int $list_id): void
{
    $user = getCurrentUser();
    $user_id = (int) $user['id'];

    if ($product_id <= 0 || $list_id <= 0) {
        http_response_code(400);
        exit('Identifiant invalide.');
    }

    $added = insertProductInList($user_id, $product_id, $list_id);

    if (!$added) {
        http_response_code(500);
        exit("Impossible d'ajouter le produit à la liste.");
    }

    redirect('account');
}


/**
 * Remove a product from a user's list.
 *
 * @param int $product_id Product ID.
 * @param int $list_id List ID.
 *
 * @return void
 */
function removeFromList(int $product_id, int $list_id): void
{
    $user = getCurrentUser();
    $user_id = (int) $user['id'];

    if ($product_id <= 0 || $list_id <= 0) {
        http_response_code(400);
        exit('Identifiant invalide.');
    }

    deleteProductFromList($user_id, $list_id, $product_id);

    redirect('list&id=' . $list_id);
}