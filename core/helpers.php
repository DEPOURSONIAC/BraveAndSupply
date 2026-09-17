<?php

/**
 * Display a view with the header and footer.
 *
 * The view path is automatically built from the views directory.
 *
 * @param string $page View page path.
 * @param array $data Data passed to the view.
 *
 * @return void
 */
function view(string $page, array $data = []): void
{
    extract($data);

    include(INCLUDE_PATH . '/header.php');

    require VIEW_PATH . '/' . $page . '.php';

    include(INCLUDE_PATH . '/footer.php');
}


/**
 * Display a partial view.
 *
 * @param string $page Partial view path.
 * @param array $data Data passed to the partial.
 *
 * @return void
 */
function partial(string $page, array $data = []): void
{
    extract($data);

    require VIEW_PATH . '/' . $page . '.php';
}


/**
 * Redirect the user to a route.
 *
 * Example:
 *     redirect('home');
 *
 * Redirects to:
 *     ?action=home
 *
 * @param string $route Route name.
 *
 * @return void
 */
function redirect(string $route): void
{
    header('Location: ?action=' . $route);

    exit;
}


/**
 * Log in a user.
 *
 * Regenerates the session ID and stores the user's information
 * in the session.
 *
 * @param array $user User data.
 *
 * @return bool True when the user is successfully logged in.
 */
function loginUser(array $user): bool
{
    session_regenerate_id(true);

    $_SESSION['id'] = $user['id'];
    $_SESSION['name'] = $user['name'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['role'] = $user['role'];

    return true;
}