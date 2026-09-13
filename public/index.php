<?php

/*
    Main entry point of the web application.
    Initializes the environment and lets the router handle the request.
*/


// ---------------
// ERROR HANDLING
// ---------------

// Do not display PHP errors to users in production.
// Errors should be logged instead.
ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');
error_reporting(E_ALL);


// ---------------
// CONFIGURATION
// ---------------

require_once __DIR__ . '/../config/config.php';


// ---------------
// SECURITY HEADERS
// ---------------

// Force HTTPS communication when the application is accessed through HTTPS.
header('Strict-Transport-Security: max-age=31536000; includeSubDomains');


// ---------------
// SESSION SECURITY
// ---------------

if (session_status() === PHP_SESSION_NONE) {

    // Prevent JavaScript from accessing the session cookie.
    ini_set('session.cookie_httponly', '1');

    // Only send the session cookie through HTTPS.
    ini_set('session.cookie_secure', '1');

    // Prevent the cookie from being sent in most cross-site requests.
    ini_set('session.cookie_samesite', 'Lax');

    session_start();
}


// ---------------
// DEPENDENCIES
// ---------------

require_once ROOT . '/config/database.php';
require_once ROOT . '/core/helpers.php';
require_once ROOT . '/core/bootstrap.php';
require_once ROOT . '/core/router.php';


// ---------------
// ROUTING
// ---------------

// Get the requested route.
$route = getRoute();

// Check whether the user is allowed to access this route.
$route = protectRoute($route);

// Get the arguments required by the route handler.
$args = getRouteArguments($route);

// Execute the function associated with the route.
executeRoute($route, $args);