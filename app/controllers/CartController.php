<?php

/**
 * Add a product to the user's cart.
 *
 * Redirects the user to the product page after the operation.
 *
 * @param int $product_id Product ID.
 * @param int $quantity Product quantity.
 *
 * @return void
 */
function addToCart(int $product_id, int $quantity = 1): void
{
    if ($quantity < 1) {
        redirect("product&id=$product_id&OK=FALSE");
    }

    $user = getCurrentUser();
    $user_id = (int) $user['id'];

    $added = insertCartItem($user_id, $product_id, $quantity);

    if ($added) {
        redirect("product&id=$product_id&OK=TRUE");
    }

    redirect("product&id=$product_id&OK=FALSE");
}


/**
 * Update the quantity of a product in the cart.
 *
 * @param int $product_id Product ID.
 * @param int $quantity New product quantity.
 *
 * @return void
 */
function updateCart(int $product_id, int $quantity): void
{
    if ($quantity < 1) {
        echo json_encode(['success' => false]);
        return;
    }

    $user = getCurrentUser();
    $user_id = (int) $user['id'];

    $updated = updateCartItemQuantity($user_id, $product_id, $quantity);

    $stats = getUserStats($user_id);
    $cart = getCart($user_id);

    echo json_encode([
        'success' => $updated,
        'cart' => $cart,
        'cart_count' => $stats['cart_count']
    ]);
}


/**
 * Remove a product from the user's cart.
 *
 * @param int $product_id Product ID.
 *
 * @return void
 */
function removeFromCart(int $product_id): void
{
    $user = getCurrentUser();
    $user_id = (int) $user['id'];

    $removed = deleteCartItem($user_id, $product_id);

    $stats = getUserStats($user_id);
    $cart = getCart($user_id);

    echo json_encode([
        'success' => $removed,
        'cart' => $cart,
        'cart_count' => $stats['cart_count']
    ]);
}


/**
 * Display the user's cart.
 *
 * Applies the current coupon if one is stored in the session.
 *
 * @return void
 */
function showCart(): void
{
    $user = getCurrentUser();
    $user_id = (int) $user['id'];

    $stats = getUserStats($user_id);
    $cart = getCart($user_id);

    $coupon = null;
    $discount = 0;

    if (!empty($_SESSION['coupon'])) {
        $coupon = validateCoupon($_SESSION['coupon']);

        if ($coupon) {
            $old_total = (float) $cart['total'];
            $new_total = applyCoupon($old_total, $coupon['code']);

            $discount = $old_total - $new_total;
            $cart['total'] = $new_total;
        }
    }

    view('user/account/cart', [
        'cart' => $cart,
        'cart_count' => $stats['cart_count'],
        'coupon' => $coupon,
        'discount' => $discount
    ]);
}


/**
 * Apply a coupon to the user's cart.
 *
 * @param string $code Coupon code.
 *
 * @return void
 */
function applyCouponToCart(string $code): void
{
    $coupon = validateCoupon($code);

    if ($coupon) {
        $_SESSION['coupon'] = $coupon['code'];
        redirect('account');
    }

    redirect('cart&coupon=FALSE');
}


/**
 * Remove the current coupon from the cart.
 *
 * @return void
 */
function removeCouponFromCart(): void
{
    unset($_SESSION['coupon']);

    redirect('account');
}