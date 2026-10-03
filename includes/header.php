<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Brave & Supply</title>

     <!-- CSS -->
     <!-- Bootstrap -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/bootstrap.min.css">

    <!-- Librairies -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/font-awesome.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/owl-carousel.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/lightbox.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/flex-slider.css">

    <!-- Template -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/templatemo-hexashop.css">

    <!-- MY CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">

    <!-- ADMIN -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/admin.css">
</head>

<body>

<header class="header-area header-sticky">

    <div class="container">

        <div class="row">

            <div class="col-12">

                <nav class="main-nav">

                    <!-- LOGO -->

                    <a href="<?= BASE_URL ?>" class="logo">
                        <img src="<?= BASE_URL ?>assets/images/logo_site.png" alt="Logo Brave & Supply" width="100">
                    </a>


                    <!-- MENU ADMIN -->

                    <?php if ($isAdmin): ?>

                        <ul class="nav">

                            <li>
                                <a href="<?= BASE_URL ?>?action=admin" class="<?= $current_action === 'admin' ? 'active' : '' ?>">
                                    <i class="fa fa-th-large"></i>
                                    Dashboard
                                </a>
                            </li>

                            <li>
                                <a href="<?= BASE_URL ?>?action=adminUsers" class="<?= $current_action === 'adminUsers' ? 'active' : '' ?>">
                                    <i class="fa fa-users"></i>
                                    Utilisateurs
                                </a>
                            </li>

                            <li>
                                <a href="<?= BASE_URL ?>?action=adminProducts" class="<?= $current_action === 'adminProducts' ? 'active' : '' ?>">
                                    <i class="fa fa-cube"></i>
                                    Produits
                                </a>
                            </li>

                            <li>
                                <a href="<?= BASE_URL ?>?action=adminOrders" class="<?= $current_action === 'adminOrders' ? 'active' : '' ?>">
                                    <i class="fa fa-shopping-bag"></i>
                                    Commandes
                                </a>
                            </li>

                            <!-- Back to store -->
                            <li>
                                <a href="<?= BASE_URL ?>">
                                    <i class="fa fa-home"></i>
                                    Boutique
                                </a>
                            </li>


                            <!-- MENU ADMIN / USER -->

                            <li class="submenu">

                                <a href="javascript:;" id="userDropdown">
                                    <i class="fa fa-user"></i>
                                    <?= $userName ?>
                                </a>

                                <ul id="userMenu">

                                    <li>
                                        <a href="<?= BASE_URL ?>?action=account">
                                            <i class="fa fa-user"></i>
                                            Mon compte
                                        </a>
                                    </li>

                                    <li>
                                        <a href="<?= BASE_URL ?>?action=logout">
                                            <i class="fa fa-sign-out"></i>
                                            Déconnexion
                                        </a>
                                    </li>

                                </ul>

                            </li>

                        </ul>


                    <!-- CLASSIC MENU -->

                    <?php else: ?>

                        <ul class="nav">

                            <!-- HOME -->
                            <li>
                                <a href="<?= BASE_URL ?>" class="<?= $current_action === '' ? 'active' : '' ?>">
                                    Accueil
                                </a>
                            </li>


                            <!-- MEN -->
                            <li>
                                <a href="<?= BASE_URL ?>?action=category&id=1" class="<?= $current_action === 'category' && ($_GET['id'] ?? '') == '1' ? 'active' : '' ?>">
                                    Hommes
                                </a>
                            </li>


                            <!-- WOMEN -->
                            <li>
                                <a href="<?= BASE_URL ?>?action=category&id=2" class="<?= $current_action === 'category' && ($_GET['id'] ?? '') == '2' ? 'active' : '' ?>">
                                    Femmes
                                </a>
                            </li>


                            <!-- KIDS -->
                            <li>
                                <a href="<?= BASE_URL ?>?action=category&id=3" class="<?= $current_action === 'category' && ($_GET['id'] ?? '') == '3' ? 'active' : '' ?>" >
                                    Enfants
                                </a>
                            </li>


                             <!-- USER MENU -->

                            <li class="submenu" id="menuUtilisateur">

                                <a href="javascript:;" id="userDropdown">

                                    <i class="fa fa-user"></i>

                                    <?= $userName ?>

                                </a>

                                <ul id="userMenu">


                                    <?php if (!$isLoggedIn): ?>

                                        <!-- VISITOR -->

                                        <li>
                                            <a href="<?= BASE_URL ?>?action=login">
                                                <i class="fa fa-sign-in"></i>
                                                Connexion
                                            </a>
                                        </li>

                                        <li>
                                            <a href="<?= BASE_URL ?>?action=register">
                                                <i class="fa fa-user-plus"></i>
                                                Inscription
                                            </a>
                                        </li>


                                    <?php else: ?>

                                         <!-- IF USER IS CONNECTED -->

                                        <li>
                                            <a href="<?= BASE_URL ?>?action=account">
                                                <i class="fa fa-user"></i>
                                                Mon compte
                                            </a>
                                        </li>

                                        <li>
                                            <a href="<?= BASE_URL ?>?action=logout">
                                                <i class="fa fa-sign-out"></i>
                                                Déconnexion
                                            </a>
                                        </li>

                                    <?php endif; ?>

                                </ul>

                            </li>


                            <!-- PAGES -->

                            <li class="submenu">

                                <a href="javascript:;">
                                    Pages
                                </a>

                                <ul>

                                    <li>
                                        <a href="<?= BASE_URL ?>?action=catalogue">
                                            Catalogue
                                        </a>
                                    </li>

                                    <li>
                                        <a href="<?= BASE_URL ?>?action=about">
                                            À propos
                                        </a>
                                    </li>

                                    <li>
                                        <a href="<?= BASE_URL ?>?action=contact">
                                            Contact
                                        </a>
                                    </li>

                                </ul>

                            </li>

                        </ul>

                    <?php endif; ?>

                </nav>

            </div>

        </div>

    </div>

</header>
