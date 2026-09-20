<?php

/**
 * Display the checkout page.
 *
 * @return void
 */
function showCheckout(): void
{
    $user = getCurrentUser();
    $user_id = (int) $user['id'];

    // Retrieve the current cart.
    $cart = getCart($user_id);

    // Prevent checkout with an empty cart.
    if (empty($cart['products'])) {
        redirect('cart');
    }

    // Calculate the number of items in the cart.
    $cart_count = 0;

    foreach ($cart['products'] as $product) {
        $cart_count += (int) $product['quantity'];
    }

    // Retrieve and validate the current coupon.
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

    // Display the checkout page.
    view('shop/checkout', [
        'products' => $cart['products'],
        'total' => $cart['total'],
        'coupon' => $coupon,
        'discount' => $discount,
        'cart_count' => $cart_count
    ]);
}


/**
 * Create a PayPal order and redirect the user to PayPal.
 *
 * @return void
 */
function paypalCreateOrder(): void
{
    $user = getCurrentUser();
    $user_id = (int) $user['id'];

    // Retrieve the current cart.
    $cart = getCart($user_id);

    // Prevent payment with an empty cart.
    if (empty($cart['products'])) {
        redirect('cart');
    }

    // Get the current cart total.
    $total_price = (float) $cart['total'];

    // Retrieve and validate the current coupon.
    if (!empty($_SESSION['coupon'])) {
        $coupon = validateCoupon($_SESSION['coupon']);

        if ($coupon) {
            $total_price = applyCoupon($total_price, $coupon['code']);
        }
    }

    // Prevent invalid totals.
    if ($total_price <= 0) {
        redirect('checkout');
    }

    // Get a PayPal access token.
    $access_token = getPayPalAccessToken();

    if (!$access_token) {
        error_log('Unable to get PayPal access token.');

        redirect('checkout');
    }

    // Prepare the PayPal order.
    $payload = [
        'intent' => 'CAPTURE',

        'purchase_units' => [
            [
                'amount' => [
                    'currency_code' => 'EUR',
                    'value' => number_format($total_price, 2, '.', ''),
                ],
            ],
        ],

        'payment_source' => [
            'paypal' => [
                'experience_context' => [
                    'return_url' => BASE_URL . '?action=paypalCaptureOrder',
                    'cancel_url' => BASE_URL . '?action=checkout',
                    'user_action' => 'PAY_NOW',
                ],
            ],
        ],
    ];

    // Send the request to PayPal.
    $ch = curl_init();

    curl_setopt_array($ch, [
        CURLOPT_URL => PAYPAL_API_URL . '/v2/checkout/orders',
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $access_token,
        ],
        CURLOPT_POSTFIELDS => json_encode($payload),
    ]);

    $response = curl_exec($ch);

    if ($response === false) {
        error_log('PayPal create order error: ' . curl_error($ch));

        curl_close($ch);

        redirect('checkout');
    }

    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    // Check PayPal response.
    if ($http_code < 200 || $http_code >= 300) {
        error_log('PayPal create order HTTP error: ' . $http_code);
        error_log('PayPal response: ' . $response);

        redirect('checkout');
    }

    $paypal_order = json_decode($response, true);

    if (!is_array($paypal_order) || empty($paypal_order['id'])) {
        error_log('Invalid PayPal create order response.');

        redirect('checkout');
    }

    // Find the PayPal approval URL.
    $approval_url = null;

    foreach ($paypal_order['links'] ?? [] as $link) {
        if (($link['rel'] ?? '') === 'payer-action') {
            $approval_url = $link['href'];
            break;
        }
    }

    if (!$approval_url) {
        error_log('PayPal approval URL not found.');

        redirect('checkout');
    }

    /*
     * Store the PayPal order ID and expected amount.
     *
     * The amount is stored server-side so we can compare it
     * with the amount actually captured by PayPal.
     */
    $_SESSION['paypal_order_id'] = $paypal_order['id'];
    $_SESSION['paypal_amount'] = number_format($total_price, 2, '.', '');

    // Redirect the user to PayPal.
    header('Location: ' . $approval_url);

    exit;
}


/**
 * Capture the PayPal order and create the local order.
 *
 * @return void
 */
function paypalCaptureOrder(): void
{
    $user = getCurrentUser();
    $user_id = (int) $user['id'];

    // Retrieve the PayPal order information from the session.
    $paypal_order_id = $_SESSION['paypal_order_id'] ?? null;
    $expected_amount = $_SESSION['paypal_amount'] ?? null;

    if (empty($paypal_order_id) || $expected_amount === null) {
        error_log('PayPal session data is missing.');

        redirect('checkout');
    }

    // Get a PayPal access token.
    $access_token = getPayPalAccessToken();

    if (!$access_token) {
        error_log('Unable to get PayPal access token.');

        redirect('checkout');
    }

    // Capture the PayPal order.
    $ch = curl_init();

    curl_setopt_array($ch, [
        CURLOPT_URL => PAYPAL_API_URL
            . '/v2/checkout/orders/'
            . urlencode($paypal_order_id)
            . '/capture',

        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,

        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $access_token,
        ],

        CURLOPT_POSTFIELDS => '{}',
    ]);

    $response = curl_exec($ch);

    if ($response === false) {
        error_log('PayPal capture error: ' . curl_error($ch));

        curl_close($ch);

        redirect('checkout');
    }

    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    // Check PayPal HTTP response.
    if ($http_code < 200 || $http_code >= 300) {
        error_log('PayPal capture HTTP error: ' . $http_code);
        error_log('PayPal response: ' . $response);

        redirect('checkout');
    }

    $paypal_capture = json_decode($response, true);

    if (!is_array($paypal_capture)) {
        error_log('Invalid PayPal capture response.');

        redirect('checkout');
    }

    // Verify that PayPal completed the payment.
    if (($paypal_capture['status'] ?? '') !== 'COMPLETED') {
        error_log(
            'PayPal payment was not completed. Status: ' .
            ($paypal_capture['status'] ?? 'unknown')
        );

        redirect('checkout');
    }

    /*
     * Retrieve the captured payment.
     *
     * PayPal returns captures inside:
     *
     * purchase_units
     *     -> payments
     *         -> captures
     */
    $capture = $paypal_capture['purchase_units'][0]['payments']['captures'][0] ?? null;

    if (!is_array($capture)) {
        error_log('PayPal capture information is missing.');

        redirect('checkout');
    }

    // Verify the capture status.
    if (($capture['status'] ?? '') !== 'COMPLETED') {
        error_log(
            'PayPal capture was not completed. Status: ' .
            ($capture['status'] ?? 'unknown')
        );

        redirect('checkout');
    }

    // Retrieve the captured amount.
    $captured_amount = $capture['amount']['value'] ?? null;
    $captured_currency = $capture['amount']['currency_code'] ?? null;

    if ($captured_amount === null || empty($captured_currency)) {
        error_log('PayPal captured amount information is missing.');

        redirect('checkout');
    }

    /*
     * Verify the currency.
     */
    if ($captured_currency !== 'EUR') {
        error_log(
            'PayPal currency mismatch. Expected EUR, received ' .
            $captured_currency
        );

        redirect('checkout');
    }

    /*
     * Verify the amount.
     *
     * We compare normalized decimal strings instead of floats.
     */
    $expected_amount = number_format((float) $expected_amount, 2, '.', '');
    $captured_amount = number_format((float) $captured_amount, 2, '.', '');

    if ($captured_amount !== $expected_amount) {
        error_log(
            'PayPal amount mismatch. Expected: ' .
            $expected_amount .
            ' / Captured: ' .
            $captured_amount
        );

        redirect('checkout');
    }

    /*
     * The payment has now been verified:
     *
     * - PayPal order exists
     * - Capture succeeded
     * - Capture status is COMPLETED
     * - Currency is EUR
     * - Captured amount matches our expected amount
     *
     * We can now create the local order.
     */
    $order_id = createOrderFromCart($user_id, 'paid');

    if (!$order_id) {
        error_log(
            'Unable to create local order after successful PayPal payment. ' .
            'PayPal order ID: ' .
            $paypal_order_id
        );

        redirect('checkout');
    }

    // Remove PayPal information from the session.
    unset($_SESSION['paypal_order_id']);
    unset($_SESSION['paypal_amount']);

    // Remove the coupon after successful order creation.
    unset($_SESSION['coupon']);

    // Redirect to the account page.
    redirect('account');
}