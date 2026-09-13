<?php include( INCLUDE_PATH . "/header.php"); ?>

<div class="admin-panel admin-orders">
    <div class="admin-panel-head">
        <h2>Commandes (<?= count($orders) ?>)</h2>
    </div>

    <?php if (empty($orders)): ?>

        <div class="account-empty">
            <p>Aucune commande pour le moment.</p>
        </div>

    <?php else: ?>

        <div class="table-responsive">
            <table class="account-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Client</th>
                        <th>Montant</th>
                        <th>Statut</th>
                        <th>Date</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td>#<?= (int) $order['id'] ?></td>
                            <td>
                                <?php if (!empty($order['user_name'])): ?>
                                    <?= htmlspecialchars($order['user_name']) ?>
                                <?php else: ?>
                                    <span class="admin-text-muted">Utilisateur #<?= (int) $order['user_id'] ?></span>
                                <?php endif; ?>
                            </td>
                            <td><?= number_format((float) $order['total_price'], 2, ',', ' ') ?> €</td>
                            <td>
                                <span class="order-status order-status--<?= htmlspecialchars($order['status'] ?? 'pending') ?>">
                                    <?= htmlspecialchars($order['status'] ?? 'pending') ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars(date('d/m/Y', strtotime($order['created_at']))) ?></td>
                            <td>
                                <a href="<?= BASE_URL ?>?action=adminOrder&id=<?= (int) $order['id'] ?>" class="admin-btn-icon">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    <?php endif; ?>
</div>

<?php include( INCLUDE_PATH . "/footer.php"); ?>
