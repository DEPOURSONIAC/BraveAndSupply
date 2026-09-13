<?php include(INCLUDE_PATH . "/header.php"); ?>

<?php
$order_info = $order['order'] ?? [];
$items = $order['items'] ?? [];
$status = $order_info['status'] ?? 'pending';
?>

<div class="admin-order-detail">

    <a
        href="<?= BASE_URL ?>?action=adminOrders"
        class="order-back-link"
    >
        &larr; Retour aux commandes
    </a>

    <div class="row">

        <!-- Produits commandés -->
        <div class="col-lg-7">

            <div class="admin-panel">

                <div class="admin-panel-head">
                    <h2>Produits commandés</h2>
                </div>

                <?php if (empty($items)): ?>

                    <div class="account-empty">
                        <p>Aucun produit sur cette commande.</p>
                    </div>

                <?php else: ?>

                    <div class="table-responsive">
                        <table class="account-table">

                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Produit</th>
                                    <th>Quantité</th>
                                    <th>Prix</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php foreach ($items as $item): ?>

                                    <tr>

                                        <td>
                                            <?php if (!empty($item['image'])): ?>

                                                <img
                                                    src="<?= BASE_URL ?>assets/images/products/<?= htmlspecialchars($item['image'], ENT_QUOTES, 'UTF-8') ?>"
                                                    alt="<?= htmlspecialchars($item['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                                    class="admin-table-thumb"
                                                >

                                            <?php else: ?>

                                                <div class="admin-table-thumb"></div>

                                            <?php endif; ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($item['name'] ?? '—', ENT_QUOTES, 'UTF-8') ?>
                                        </td>

                                        <td class="order-qty-cell">
                                            <?= (int) ($item['quantity'] ?? 0) ?>
                                        </td>

                                        <td>
                                            <?= number_format(
                                                (float) ($item['price'] ?? 0),
                                                2,
                                                ',',
                                                ' '
                                            ) ?>
                                            €
                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            </tbody>

                        </table>
                    </div>

                <?php endif; ?>

                <div class="order-summary">
                    <div class="order-summary-line order-summary-line--total">
                        <span>Total</span>

                        <span>
                            <?= number_format(
                                (float) ($order_info['total_price'] ?? 0),
                                2,
                                ',',
                                ' '
                            ) ?>
                            €
                        </span>
                    </div>
                </div>

            </div>

        </div>


        <!-- Informations commande -->
        <div class="col-lg-5">

            <div class="admin-panel">

                <div class="admin-panel-head">
                    <h2>Commande</h2>
                </div>

                <ul class="order-info-list">

                    <li>
                        <span>Numéro</span>

                        <strong>
                            #<?= (int) ($order_info['id'] ?? 0) ?>
                        </strong>
                    </li>

                    <li>
                        <span>Date</span>

                        <strong>
                            <?= htmlspecialchars(
                                date(
                                    'd/m/Y H:i',
                                    strtotime($order_info['created_at'] ?? 'now')
                                ),
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </strong>
                    </li>

                    <li>
                        <span>Statut</span>

                        <strong>
                            <span class="order-status order-status--<?= htmlspecialchars($status, ENT_QUOTES, 'UTF-8') ?>">
                                <?= htmlspecialchars($status, ENT_QUOTES, 'UTF-8') ?>
                            </span>
                        </strong>
                    </li>

                </ul>

                <?php if ($status === 'paid'): ?>

                    <form
                        action="<?= BASE_URL ?>?action=adminMarkOrderReceived"
                        method="post"
                        class="admin-order-action"
                    >
                        <input
                            type="hidden"
                            name="id"
                            value="<?= (int) ($order_info['id'] ?? 0) ?>"
                        >

                        <button
                            type="submit"
                            class="admin-btn-primary"
                        >
                            Marquer comme reçue
                        </button>
                    </form>

                <?php elseif ($status === 'received'): ?>

                    <p class="admin-text-muted admin-order-message">
                        Commande déjà réceptionnée.
                    </p>

                <?php else: ?>

                    <p class="admin-text-muted admin-order-message">
                        En attente de paiement — aucune action possible pour l'instant.
                    </p>

                <?php endif; ?>

            </div>


            <!-- Client -->
            <div class="admin-panel">

                <div class="admin-panel-head">
                    <h2>Client</h2>
                </div>

                <ul class="order-info-list">

                    <li>
                        <span>Nom</span>

                        <strong>
                            <?= htmlspecialchars(
                                $order_info['user_name'] ?? '—',
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </strong>
                    </li>

                    <li>
                        <span>Email</span>

                        <strong>
                            <?= htmlspecialchars(
                                $order_info['user_email'] ?? '—',
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </strong>
                    </li>

                    <li>
                        <span>Adresse</span>

                        <strong>
                            <?= htmlspecialchars(
                                $order_info['user_address'] ?? '—',
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </strong>
                    </li>

                </ul>

            </div>

        </div>

    </div>

</div>

<?php include(INCLUDE_PATH . "/footer.php"); ?>