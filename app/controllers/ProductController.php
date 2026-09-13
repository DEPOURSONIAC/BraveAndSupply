<?php

/**
 * Display the product catalogue.
 *
 * @return void
 */
function showCatalogue(): void
{
    $products = getAllProducts();

    view('shop/catalogue', [
        'products' => $products
    ]);
}


/**
 * Display the products from a category.
 *
 * @param int $category_id Category ID.
 *
 * @return void
 */
function showCategory(int $category_id): void
{
    if ($category_id <= 0) {
        http_response_code(400);
        exit('Identifiant de catégorie invalide.');
    }

    $products = getProductsByCategory($category_id);

    if (!$products) {
        http_response_code(404);
        exit('Catégorie introuvable.');
    }

    view('shop/category', [
        'products' => $products
    ]);
}


/**
 * Display a product.
 *
 * Also loads the user's lists for the product page.
 *
 * @param int $product_id Product ID.
 *
 * @return void
 */
function showProduct(int $product_id): void
{
    if ($product_id <= 0) {
        http_response_code(400);
        exit('Identifiant de produit invalide.');
    }

    $product = getProductById($product_id);

    if (!$product) {
        http_response_code(404);
        exit('Produit introuvable.');
    }

    $user = getCurrentUser();
    $user_id = (int) $user['id'];

    $lists = getLists($user_id);

    view('shop/product', [
        'product' => $product,
        'lists'   => $lists
    ]);
}
