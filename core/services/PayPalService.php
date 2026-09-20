<?php

/**
 * Get a PayPal access token.
 *
 * @return string|null Access token or null on failure.
 */
function getPayPalAccessToken(): ?string
{
    $ch = curl_init();

    curl_setopt_array($ch, [
        CURLOPT_URL => PAYPAL_API_URL . '/v1/oauth2/token',
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_USERPWD => PAYPAL_CLIENT_ID . ':' . PAYPAL_CLIENT_SECRET,
        CURLOPT_HTTPHEADER => [
            'Accept: application/json',
            'Accept-Language: en_US',
            'Content-Type: application/x-www-form-urlencoded',
        ],
        CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
    ]);

    $response = curl_exec($ch);

    if ($response === false) {
        error_log('PayPal OAuth error: ' . curl_error($ch));
        curl_close($ch);
        return null;
    }

    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    if ($http_code < 200 || $http_code >= 300) {
        error_log('PayPal OAuth HTTP error: ' . $http_code);
        error_log('PayPal OAuth response: ' . $response);
        return null;
    }

    $data = json_decode($response, true);

    if (!is_array($data) || empty($data['access_token'])) {
        error_log('PayPal OAuth invalid response.');
        return null;
    }

    return $data['access_token'];
}