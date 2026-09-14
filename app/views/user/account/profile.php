<!-- Dashboard -->
<div class="row gy-4 account-stats">

    <div class="col-4">
        <h3 class="account-stat-number">
            <?= (int) $order_count ?>
        </h3>

        <p class="account-stat-label">
            Commandes
        </p>
    </div>

    <div class="col-4">
        <h3 class="account-stat-number">
            <?= (int) $cart_count ?>
        </h3>

        <p class="account-stat-label">
            Articles au panier
        </p>
    </div>

    <div class="col-4">
        <h3 class="account-stat-number">
            <?= (int) $review_count ?>
        </h3>

        <p class="account-stat-label">
            Avis publiés
        </p>
    </div>

</div>


<!-- Privates data -->
<div class="account-section">

    <div class="account-section-header">

        <h5>Informations personnelles</h5>

        <a href="<?= BASE_URL ?>?action=accountEdit">
            Modifier
        </a>

    </div>

    <div class="row gy-4">

        <div class="col-sm-4">

            <small>Pseudo</small>

            <span>
                <?= htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8') ?>
            </span>

        </div>

        <div class="col-sm-4">

            <small>Adresse e-mail</small>

            <span>
                <?= htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8') ?>
            </span>

        </div>

    </div>

</div>


<!-- Order's last -->
<div class="account-order">

    <div class="account-section-header">

        <h5>Dernière commande</h5>

    </div>

    <?php if (!empty($order_last)): ?>

        <div class="account-order-box">

            <!-- Number -->
            <div>
                <span>N° commande</span>

                <strong>
                    #<?= (int) $order_last['id'] ?>
                </strong>
            </div>


            <!-- Date -->
            <div>
                <span>Date</span>

                <strong>
                    <?= htmlspecialchars($order_last['created_at'], ENT_QUOTES, 'UTF-8') ?>
                </strong>
            </div>


            <!-- Total -->
            <div>
                <span>Total</span>

                <strong>
                    <?= number_format( (float) $order_last['total_price'], 2, ',', ' ') ?> €
                </strong>
            </div>


            <!-- Status -->
            <div>

                <span class="account-status">
                    <?= htmlspecialchars($order_last['status'], ENT_QUOTES, 'UTF-8') ?>
                </span>

            </div>


            <!-- Detail -->
            <a href="<?= BASE_URL ?>?action=order&id=<?= (int) $order_last['id'] ?>">
                Voir le détail ->
            </a>

        </div>

    <?php else: ?>

        <div class="account-order-box">

            <p>Aucune commande pour le moment.</p>

        </div>

    <?php endif; ?>

</div>