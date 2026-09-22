<?php

/*
    Project configuration.

    Contains:
    - Project paths
    - Application URL
    - Database configuration
    - Application constants
*/

// --------------------
// PROJECT ROOT
// --------------------

define('ROOT', dirname(__DIR__));

define('APP_PATH', ROOT . '/app');
define('MODEL_PATH', APP_PATH . '/models');
define('VIEW_PATH', APP_PATH . '/views');
define('CONTROLLER_PATH', APP_PATH . '/controllers');

define('CORE_PATH', ROOT . '/core');
define('SERVICE_PATH', CORE_PATH . '/services');

define('INCLUDE_PATH', ROOT . '/includes');
define('PUBLIC_PATH', ROOT . '/public');

// --------------------
// URL
// --------------------

define('BASE_URL', 'http://localhost/brave_and_supply/');


// --------------------
// DATABASE
// --------------------

define('DB_PATH', ROOT . '/config/brave_and_supply.db');


// --------------------
// CATEGORIES
// --------------------

define('CATEGORY_HOMME', 1);
define('CATEGORY_FEMME', 2);
define('CATEGORY_KIDS', 3);


// --------------------
// Paypal
// --------------------

    // YOUR_PAYPAL_CLIENT_ID
    // YOUR_PAYPAL_CLIENT_SECRET
define('PAYPAL_CLIENT_ID', 'ASEerllv1WTjib8bJ_IH1jdqcY0BbpJc1YVyYrQxeTFzmiu8HLF15u9YrTuIRwkk1eGr2B-72przfK_n');
define('PAYPAL_CLIENT_SECRET', 'EILgYetarVIeV4bNE4vxtqRG5QBVtiLzTu30aeALooz6ZgEkkn85zKX59Wb7NmPPpSaoCqnt2oGRdXix');

define('PAYPAL_API_URL', 'https://api-m.sandbox.paypal.com');