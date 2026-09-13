<?php

/**
 * Display the login page.
 *
 * @return void
 */
function showLogin(): void
{
    view('auth/login');
}


/**
 * Display the registration page.
 *
 * @return void
 */
function showRegister(): void
{
    view('auth/register');
}


/**
 * Authenticate a user.
 *
 * @param string $email User email.
 * @param string $password User password.
 *
 * @return void
 */
function login(string $email, string $password): void
{
    if ($email === '' || $password === '') {
        exit('Champs manquants.');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        exit('Adresse email invalide.');
    }

    $user = getUserByEmail($email);

    if (!$user || !password_verify($password, $user['password'])) {
        exit('Identifiants incorrects.');
    }

    loginUser($user);

    redirect('home');
}


/**
 * Register a new user.
 *
 * Validates the submitted information, creates the account,
 * then logs the user in.
 *
 * @param string $name User name.
 * @param string $email User email.
 * @param string $address User address.
 * @param string $password User password.
 * @param string $password_confirm Password confirmation.
 *
 * @return void
 */
function register(string $name, string $email, string $address, string $password, string $password_confirm): void
{
    if ($name === '' || $email === '' || $address === '' || $password === '' || $password_confirm === '') {
        exit('Champs manquants.');
    }

    if ($password !== $password_confirm) {
        exit('Les mots de passe ne correspondent pas.');
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    createUser($name, $email, $address, $hashed_password);

    $user = getUserByEmail($email);

    if (!$user) {
        exit('Impossible de récupérer le compte créé.');
    }

    loginUser($user);

    redirect('home');
}


/**
 * Log out the current user.
 *
 * @return void
 */
function logout(): void
{
    // Clear session data.
    $_SESSION = [];

    // Delete the session cookie.
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();

        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }

    // Destroy the session.
    session_destroy();

    redirect('login');
}