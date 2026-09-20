# BraveAndSupply

BraveAndSupply is a custom-built e-commerce platform for selling costumes.

The project was developed from scratch using a lightweight MVC architecture, with a focus on clean code, maintainability, security, and a clear separation of responsibilities.

---

## Features

* User registration and authentication
* User profile management
* Product catalogue
* Product categories
* Shopping cart
* Favorites
* Custom product lists
* Product reviews
* Coupon and discount management
* Order management
* Administrator area
* PayPal Sandbox payment integration
* Responsive interface
* SQLite database
* Server-side validation
* Prepared SQL statements
* Session-based authentication
* XSS protection through output escaping

---

## Technologies

* **PHP** — Backend and application logic
* **MVC** — Custom lightweight architecture
* **SQLite** — Database
* **PDO** — Database access
* **HTML5** — Page structure
* **CSS3** — Styling
* **JavaScript** — Client-side interactions and AJAX
* **Apache** — Local/server environment
* **PayPal REST API** — Sandbox payment integration

---

## Architecture

BraveAndSupply uses a custom MVC architecture.

The application is divided into several responsibilities:

* **Controllers** handle application flow and user requests.
* **Models** handle database operations and business-related data access.
* **Views** handle the presentation layer.
* **Core** contains the bootstrap process, routing, helpers, and services.
* **Config** contains application and database configuration.
* **Public** contains the web entry point and public assets.
* **Includes** contains reusable layout components.
* **Storage** contains application logs.

The project uses a lightweight custom router instead of a full-stack PHP framework.

---

## Project Structure

```text
BraveAndSupply/
│
├── app/
│   ├── controllers/
│   │   ├── AuthController.php
│   │   ├── HomeController.php
│   │   ├── LegalController.php
│   │   ├── ProductController.php
│   │   └── UserController.php
│   │
│   ├── models/
│   │   ├── AuthModel.php
│   │   ├── CartModel.php
│   │   ├── CategoryModel.php
│   │   ├── CouponModel.php
│   │   ├── FavoriteModel.php
│   │   ├── OrderModel.php
│   │   ├── ProductListModel.php
│   │   ├── ProductModel.php
│   │   ├── ReviewModel.php
│   │   └── UserModel.php
│   │
│   └── views/
│       ├── user/
│       │   ├── account.php
│       │   └── account/
│       │       ├── profile.php
│       │       ├── orders.php
│       │       ├── order.php
│       │       ├── list.php
│       │       ├── lists.php
│       │       ├── cart.php
│       │       ├── edit.php
│       │       └── reviews.php
│       │
│       ├── auth/
│       │   ├── login.php
│       │   └── register.php
│       │
│       ├── adadmin/
│       │   ├── dashboard.php
│       │   ├── order.php
│       │   ├── orders.php
│       │   ├── products.php
│       │   └── users.php
|       |
│       ├── legal/
│       │   ├── cgv.php
│       │   ├── infos.php
│       │   ├── mentions.php
│       │   └── reglement.php
│       │
│       ├── shop/
│       │   ├── catalogue.php
│       │   ├── category.php
│       │   ├── product.php
│       │   ├── favorite.php
│       │   └── checkout.php
│       │
│       ├── annex/
│       │   ├── about.php
│       │   └── contact.php
│       │
│       └── home.php
│
├── config/
│   ├── .htaccess
│   ├── braveandsupplyv2.db
│   ├── braveAndSupplyV2.sql
│   ├── config.php
│   └── database.php
│
├── core/
│   ├── .htaccess
│   ├── bootstrap.php
│   ├── helpers.php
│   ├── router.php
│   └── services/
│       └── PayPalService.php
│
├── deployment/
│   ├── .htaccess
│   └── apache2/
│       └── sites-available/
│           └── 000-default.conf
│
├── includes/
│   ├── header.php
│   ├── footer.php
│
├── public/
│   ├── index.php
│   └── assets/
│       ├── css/
│       │   ├── style.css
│       │   ├── bootstrap.css
│       │   └── admin.css
│       │
│       ├── js/
│       │   └── ajax.js
│       │
│       └── images/
│           ├── logo.png
│           └── users/
│
├── storage/
│   └── logs/
│       ├── error.log
│       └── success.log
│
└── README.md
```

> The structure above represents the main application organization. Additional files may be present depending on the local development environment.

---

## Security

Security was considered throughout the application rather than being handled in a single layer.

The project includes:

* PDO prepared statements to prevent SQL injection
* Server-side input validation
* Output escaping to reduce XSS risks
* Password hashing using PHP's password hashing API
* Session regeneration after authentication
* Authentication and administrator route protection
* Separation between public files and application logic
* Server-side verification of PayPal payment data
* Sensitive PayPal credentials kept on the server

Payment amounts are also verified against the values returned by PayPal before a local order is created.

---

## Payment

BraveAndSupply integrates **PayPal Sandbox** for payment testing.

The payment flow is handled server-side:

```text
Checkout
   │
   v
Create PayPal Order
   │
   v
PayPal Sandbox
   │
   v
Payment Approval
   │
   v
Capture Payment
   │
   v
Verify Payment
   │
   v
Create Local Order
```

The PayPal Client Secret is never exposed to the client-side code.

For development, the project uses:

* PayPal Sandbox API
* Sandbox Business account as the seller
* Sandbox Personal account as the test buyer
* Sandbox REST API credentials

Production credentials must be configured separately before a live deployment.

---

## Database

BraveAndSupply uses **SQLite** through PHP PDO.

The database schema is provided in:

```text
config/braveAndSupplyV2.sql
```

The local SQLite database is stored in:

```text
config/braveandsupplyv2.db
```

Database access is centralized through the application's database configuration.

---

## Naming Conventions

The project follows consistent naming conventions to keep the code readable and maintainable.

### Variables and parameters

`snake_case`

```php
$user_id
$product_id
$total_price
```

### Functions

`camelCase`

```php
getCurrentUser()
addToCart()
createOrder()
```

### PHP files

`PascalCase`

```text
UserController.php
CartModel.php
PayPalService.php
```

### Constants

`UPPER_SNAKE_CASE`

```php
BASE_URL
MODEL_PATH
PAYPAL_CLIENT_ID
```

### SQL tables

`snake_case`

```text
cart_items
order_items
product_lists
```

### SQL columns

`snake_case`

```text
user_id
product_id
created_at
```

---

## Installation

### Requirements

* PHP 8.x
* Apache
* PDO SQLite
* PHP cURL extension
* SQLite
* Git (optional)

### 1. Clone or copy the project

Place the project inside your Apache web directory.

Example:

```text
htdocs/
└── BraveAndSupply/
```

### 2. Configure the application

Update the application configuration in:

```text
config/config.php
```

The local base URL should point to the project directory.

Example:

```php
define('BASE_URL', 'http://localhost/BraveAndSupply/');
```

### 3. Configure the database

Make sure SQLite is enabled and the database file is available:

```text
config/braveandsupplyv2.db
```

The SQL schema can be found in:

```text
config/braveAndSupplyV2.sql
```

### 4. Configure PayPal Sandbox

Add your PayPal Sandbox REST API credentials to the application configuration.

```php
define('PAYPAL_CLIENT_ID', 'your-client-id');
define('PAYPAL_CLIENT_SECRET', 'your-client-secret');
define('PAYPAL_API_URL', 'https://api-m.sandbox.paypal.com');
```

The Client Secret must remain private and must never be committed to a public repository.

### 5. Start Apache

Open the application in your browser:

```text
http://localhost/BraveAndSupply/
```

---

## Testing

The project was tested manually throughout development.

The main application flows include:

* User registration
* User login and logout
* Product browsing
* Category browsing
* Cart creation and modification
* Cart item removal
* Favorites
* Custom lists
* Reviews
* Coupons
* Checkout
* Order creation
* Administrator access
* PayPal Sandbox integration

The PayPal Sandbox flow can be tested using a Sandbox Personal account as the customer.

---

## Development Notes

BraveAndSupply was intentionally built without a full PHP framework.

The goal was to understand and implement the fundamental concepts behind a web application architecture:

* HTTP routing
* Controllers
* Models
* Views
* Sessions
* Authentication
* Database access
* CRUD operations
* Form handling
* AJAX requests
* API integration
* Payment processing
* Access control
* Application configuration

This approach keeps the application lightweight while providing a clear understanding of how the different layers interact.

---

## Project Status

**Completed**

The main e-commerce functionality is implemented, including authentication, catalogue management, cart management, user features, orders, administration, and PayPal Sandbox integration.

The project is currently in its final documentation and presentation stage.