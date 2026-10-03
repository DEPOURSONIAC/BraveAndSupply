<?php

/**
 * Define all application routes.
 *
 * Each route specifies:
 * - the HTTP method;
 * - the controller function to execute;
 * - the parameters required by the controller;
 * - whether administrator privileges are required.
 *
 * @return array
 */
function allRoutes(): array
{
    return [

        // General pages

        'home' => [
            'GET' => [
                'function' => 'showHome',
                'params' => []
            ]
        ],

        'contact' => [
            'GET' => [
                'function' => 'showContact',
                'params' => []
            ]
        ],

        'about' => [
            'GET' => [
                'function' => 'showAbout',
                'params' => []
            ]
        ],

        // Legal pages

        'infos' => [
            'GET' => [
                'function' => 'showInfos',
                'params' => []
            ]
        ],

        'cgv' => [
            'GET' => [
                'function' => 'showCgv',
                'params' => []
            ]
        ],

        'reglement' => [
            'GET' => [
                'function' => 'showReglement',
                'params' => []
            ]
        ],

        'mentions' => [
            'GET' => [
                'function' => 'showMentions',
                'params' => []
            ]
        ],

        // User account

        'account' => [
            'GET' => [
                'function' => 'showAccount',
                'params' => []
            ]
        ],

        'profile' => [
            'GET' => [
                'function' => 'showProfile',
                'params' => []
            ]
        ],

        'orders' => [
            'GET' => [
                'function' => 'showOrders',
                'params' => []
            ]
        ],

        'order' => [
            'GET' => [
                'function' => 'showOrder',
                'params' => [
                    'id'
                ]
            ]
        ],

        'reviews' => [
            'GET' => [
                'function' => 'showReviews',
                'params' => []
            ]
        ],

        // Favorites

        'favorite' => [
            'GET' => [
                'function' => 'showFavorite',
                'params' => []
            ]
        ],

        'addToFavorite' => [
            'POST' => [
                'function' => 'addToFavorite',
                'params' => [
                    'product_id'
                ]
            ]
        ],

        'removeFromFavorite' => [
            'POST' => [
                'function' => 'removeFromFavorite',
                'params' => [
                    'product_id'
                ]
            ]
        ],

        // Reviews

        'createReview' => [
            'POST' => [
                'function' => 'createReview',
                'params' => [
                    'comment'
                ]
            ]
        ],

        'removeReview' => [
            'POST' => [
                'function' => 'removeReview',
                'params' => [
                    'review_id'
                ]
            ]
        ],

        // Account editing

        'accountEdit' => [
            'GET' => [
                'function' => 'showAccountEdit',
                'params' => []
            ],

            'POST' => [
                'function' => 'updateProfile',
                'params' => [
                    'name',
                    'email',
                    'address',
                    'new_password'
                ]
            ]
        ],

        // Coupons

        'applyCoupon' => [
            'POST' => [
                'function' => 'applyCouponToCart',
                'params' => [
                    'code'
                ]
            ]
        ],

        'removeCoupon' => [
            'POST' => [
                'function' => 'removeCouponFromCart',
                'params' => []
            ]
        ],

        // Lists

        'lists' => [
            'GET' => [
                'function' => 'showLists',
                'params' => []
            ]
        ],

        'createList' => [
            'POST' => [
                'function' => 'createList',
                'params' => [
                    'name'
                ]
            ]
        ],

        'deleteList' => [
            'POST' => [
                'function' => 'deleteList',
                'params' => [
                    'list_id'
                ]
            ]
        ],

        'list' => [
            'GET' => [
                'function' => 'showList',
                'params' => [
                    'id'
                ]
            ]
        ],

        'addToList' => [
            'POST' => [
                'function' => 'addToList',
                'params' => [
                    'product_id',
                    'list_id'
                ]
            ]
        ],

        'removeFromList' => [
            'POST' => [
                'function' => 'removeFromList',
                'params' => [
                    'product_id',
                    'list_id'
                ]
            ]
        ],

        // Cart

        'cart' => [
            'GET' => [
                'function' => 'showCart',
                'params' => []
            ]
        ],

        'addToCart' => [
            'POST' => [
                'function' => 'addToCart',
                'params' => [
                    'product_id',
                    'quantity'
                ]
            ]
        ],

        'updateCart' => [
            'POST' => [
                'function' => 'updateCart',
                'params' => [
                    'product_id',
                    'quantity'
                ]
            ]
        ],

        'removeFromCart' => [
            'POST' => [
                'function' => 'removeFromCart',
                'params' => [
                    'product_id'
                ]
            ]
        ],

        // Authentication

        'login' => [
            'GET' => [
                'function' => 'showLogin',
                'params' => []
            ],

            'POST' => [
                'function' => 'login',
                'params' => [
                    'email',
                    'password'
                ]
            ]
        ],

        'register' => [
            'GET' => [
                'function' => 'showRegister',
                'params' => []
            ],

            'POST' => [
                'function' => 'register',
                'params' => [
                    'name',
                    'email',
                    'address',
                    'password',
                    'password_confirm'
                ]
            ]
        ],

        'logout' => [
            'GET' => [
                'function' => 'logout',
                'params' => []
            ]
        ],

        // Products

        'product' => [
            'GET' => [
                'function' => 'showProduct',
                'params' => [
                    'id'
                ]
            ]
        ],

        // Catalogue

        'catalogue' => [
            'GET' => [
                'function' => 'showCatalogue',
                'params' => []
            ]
        ],

        // Categories

        'category' => [
            'GET' => [
                'function' => 'showCategory',
                'params' => [
                    'id'
                ]
            ]
        ],

        // PayPal / Checkout

        'checkout' => [
            'GET' => [
                'function' => 'showCheckout',
                'params' => []
            ]
        ],

        'paypalCreateOrder' => [
            'POST' => [
                'function' => 'paypalCreateOrder',
                'params' => []
            ]
        ],

        'paypalCaptureOrder' => [
            'GET' => [
                'function' => 'paypalCaptureOrder',
                'params' => []
            ]
        ],

        // Administrator area

        'admin' => [
            'GET' => [
                'function' => 'showAdmin',
                'params' => []
            ],
            'admin' => true
        ],

        'adminUsers' => [
            'GET' => [
                'function' => 'showAdminUsers',
                'params' => []
            ],
            'admin' => true
        ],

        'adminProducts' => [
            'GET' => [
                'function' => 'showAdminProducts',
                'params' => []
            ],
            'admin' => true
        ],

        'adminOrders' => [
            'GET' => [
                'function' => 'showAdminOrders',
                'params' => []
            ],
            'admin' => true
        ],

        'adminOrder' => [
            'GET' => [
                'function' => 'showAdminOrder',
                'params' => [
                    'id'
                ]
            ],
            'admin' => true
        ],

        // Administrator product management

        'adminAddProduct' => [
            'POST' => [
                'function' => 'adminAddProduct',
                'params' => [
                    'name',
                    'description',
                    'price',
                    'quantity'
                ]
            ],
            'admin' => true
        ],

        'adminEditProduct' => [
            'POST' => [
                'function' => 'adminEditProduct',
                'params' => [
                    'id',
                    'name',
                    'description',
                    'price',
                    'quantity'
                ]
            ],
            'admin' => true
        ],

        'adminDeleteProduct' => [
            'POST' => [
                'function' => 'adminDeleteProduct',
                'params' => [
                    'id'
                ]
            ],
            'admin' => true
        ],

        'adminDeleteUser' => [
            'POST' => [
                'function' => 'adminDeleteUser',
                'params' => [
                    'id'
                ]
            ],
            'admin' => true
        ],

        'adminMarkOrderReceived' => [
            'POST' => [
                'function' => 'adminMarkOrderReceived',
                'params' => [
                    'id'
                ]
            ],
            'admin' => true
        ],
    ];
}


/**
 * Retrieve the requested route.
 *
 * The route is determined from the "action" GET parameter.
 * If no action is provided, the home route is used.
 *
 * @return array The requested route configuration.
 */
function getRoute(): array
{
    $routes = allRoutes();

    $action = $_GET['action'] ?? 'home';

    if (!isset($routes[$action])) {
        http_response_code(404);
        exit('Page not found');
    }

    $route = $routes[$action];
    $route['name'] = $action;

    return $route;
}


/**
 * Check whether the current user is authorized to access a route.
 *
 * This function handles:
 * - authentication requirements;
 * - access to login and registration pages;
 * - administrator-only routes.
 *
 * @param array $route The requested route configuration.
 *
 * @return array The authorized route configuration.
 */
function protectRoute(array $route): array
{
    $is_logged = isset($_SESSION['id']);
    $is_admin = isset($_SESSION['role'])  && $_SESSION['role'] === 'admin';

    $routes = allRoutes();

    // Redirect unauthenticated users to the login page.
    if (
        !$is_logged
        && !in_array($route['name'], ['login', 'register'], true)
    ) {
        $route = $routes['login'];
        $route['name'] = 'login';
    }

    // Prevent authenticated users from accessing login and registration.
    if ($is_logged && in_array($route['name'], ['login', 'register'], true)) {
        $route = $routes['home'];
        $route['name'] = 'home';
    }


    // Restrict administrator routes to administrators.
    if (($route['admin'] ?? false) === true && !$is_admin) {
        $route = $routes['home'];
        $route['name'] = 'home';
    }

    return $route;
}


/**
 * Retrieve the arguments required by the current route.
 *
 * Parameters are read from GET or POST according to the HTTP method.
 * The arguments are returned in the same order as defined by the route.
 *
 * @param array $route The current route configuration.
 *
 * @return array The arguments to pass to the controller function.
 */
function getRouteArguments(array $route): array
{
    $method = $_SERVER['REQUEST_METHOD'];

    if (!isset($route[$method])) {
        http_response_code(405);
        exit('Method not allowed');
    }

    $params = $route[$method]['params'];

    $source = match ($method) {
        'GET' => $_GET,
        'POST' => $_POST,
        default => []
    };

    $args = [];

    foreach ($params as $param) {
        if (!isset($source[$param])) {
            exit("Missing parameter: $param");
        }

        $args[] = $source[$param];
    }

    return $args;
}


/**
 * Execute the controller function associated with the current route.
 *
 * @param array $route The current route configuration.
 * @param array $args Arguments passed to the controller function.
 *
 * @return void
 */
function executeRoute(array $route, array $args): void
{
    $method = $_SERVER['REQUEST_METHOD'];

    if (!isset($route[$method])) {
        http_response_code(405);
        exit('Method not allowed');
    }

    $function = $route[$method]['function'];

    $function(...$args);
}