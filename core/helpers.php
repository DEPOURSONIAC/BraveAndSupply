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
    $current_action = $_GET['action'] ?? '';

    $isLoggedIn = isset($_SESSION['id']);
    $isAdmin = $isLoggedIn && isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    $userName = $isLoggedIn ? htmlspecialchars($_SESSION['name'] ?? 'Utilisateur', ENT_QUOTES, 'UTF-8') : 'Invité';

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


/**

* Write a successful operation to the success log.
*
* @param string $message Message describing the successful operation.
* @param string $ip      IP address associated with the operation.
*
* @return void
  */
  function logSuccess(string $message, string $ip): void
{
    $log = sprintf("[%s] [SUCCESS] %s - IP: %s%s",date('Y-m-d H:i:s'), $message,$ip,PHP_EOL);

    file_put_contents(__DIR__ . '/../storage/logs/success.log',$log,FILE_APPEND | LOCK_EX);
}

/**

* Write an error to the error log.
*
* @param string $message Message describing the error.
* @param string $ip      IP address associated with the error.
*
* @return void
 */
function logError(string $message, string $ip): void
{
    $log = sprintf("[%s] [ERROR] %s - IP: %s%s", date('Y-m-d H:i:s'), $message, $ip, PHP_EOL);

    file_put_contents(__DIR__ . '/../storage/logs/error.log', $log, FILE_APPEND | LOCK_EX);
}