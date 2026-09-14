<div class="container order-page">

    <!-- Back to account -->
    <div class="row">
        <div class="col-12">
            <a href="<?= BASE_URL ?>?action=account" class="order-back-link">
                <i class="fa fa-angle-left"></i>
                Retour au compte pour avoir accès aux commandes
            </a>
        </div>
    </div>

    <!-- ***** Datain the order / delivery / checkout ***** -->
    <div class="row mobile-top-fix">

        <!-- Informations commande -->
        <div class="col-lg-4 col-12 mobile-bottom-fix">
            <div class="account-section">

                <div class="account-section-header">
                    <h5>Informations commande</h5>
                </div>

                <ul class="order-info-list">

                    <li>
                        <span>Numéro</span>
                        <strong>
                            #<?= (int) $order['id'] ?>
                        </strong>
                    </li>

                    <li>
                        <span>Date</span>
                        <strong>
                            <?= htmlspecialchars($order['created_at'], ENT_QUOTES, 'UTF-8') ?>
                        </strong>
                    </li>

                </ul>

            </div>
        </div>

        <!-- Delivery -->
        <div class="col-lg-4 col-12 mobile-bottom-fix">
            <div class="account-section">

                <div class="account-section-header">
                    <h5>Livraison</h5>
                </div>

                <ul class="order-info-list">

                    <li>
                        <span>Mode</span>
                        <strong>Livraison standard</strong>
                    </li>

                    <li>
                        <span>Statut</span>
                        <strong>
                            <?= htmlspecialchars($status, ENT_QUOTES, 'UTF-8') ?>
                        </strong>
                    </li>

                </ul>

            </div>
        </div>

        <!-- Checkout -->
        <div class="col-lg-4 col-12 mobile-bottom-fix">
            <div class="account-section">

                <div class="account-section-header">
                    <h5>Paiement</h5>
                </div>

                <ul class="order-info-list">

                    <li>
                        <span>Méthode</span>
                        <strong>PayPal</strong>
                    </li>

                    <li>
                        <span>Statut</span>
                        <span class="order-status order-status--<?= htmlspecialchars($status, ENT_QUOTES, 'UTF-8') ?>">
                            <?= htmlspecialchars($status_label, ENT_QUOTES, 'UTF-8') ?>
                        </span>
                    </li>

                </ul>

            </div>
        </div>

    </div>

    <!-- ***** Products in the order ***** -->
    <div class="row">

        <div class="col-12">

            <div class="account-section">

                <div class="account-section-header">

                    <h5>Produits commandés</h5>

                    <span class="account-table-count">
                        <?= $total_items ?> article(s)
                    </span>

                </div>

                <div class="table-responsive">

                    <table class="account-table">

                        <thead>
                            <tr>
                                <th>Produit</th>
                                <th>Prix unitaire</th>
                                <th>Quantité</th>
                                <th>Total</th>
                            </tr>
                        </thead>

                        <tbody>

                        <?php foreach ($items as $item): ?>

                            <tr>

                                <td>
                                    <div class="account-table-product">

                                        <img src="<?= BASE_URL ?>assets/images/products/<?= htmlspecialchars($item['image'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') ?>" class="account-table-thumb">

                                        <span>
                                            <?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') ?>
                                        </span>

                                    </div>
                                </td>

                                <td style="color: black;">
                                    <?= number_format((float) $item['price'], 2, ',', ' ') ?> €
                                </td>

                                <td class="order-qty-cell">
                                    <?= (int) $item['quantity'] ?>
                                </td>

                                <td>
                                    <strong style="color: black;">
                                        <?= number_format((float) $item['price'] * (int) $item['quantity'], 2, ',', ' ') ?> €
                                    </strong>
                                </td>

                            </tr>

                        <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>

                <!-- ***** Summ up of the order ***** -->
                <div class="order-summary">
                    <div class="order-summary-line">
                        <span>Livraison</span>
                        <span>Gratuite</span>
                    </div>

                    <div class="order-summary-line order-summary-line--total">

                        <span>Total</span>

                        <strong style="color: black;">
                            <?= number_format((float) $order['total_price'], 2, ',', ' ') ?> €
                        </strong>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>