<?php include( INCLUDE_PATH . "/header.php"); ?>

<div class="admin-panel admin-users">
    <div class="admin-panel-head">
        <h2>Utilisateurs (<?= count($users) ?>)</h2>
    </div>

    <?php if (empty($users)): ?>

        <div class="account-empty">
            <p>Aucun utilisateur enregistré.</p>
        </div>

    <?php else: ?>

        <div class="table-responsive">
            <table class="account-table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Adresse</th>
                        <th>Rôle</th>
                        <?php if (!empty($users[0]['created_at'])): ?>
                            <th>Inscrit le</th>
                        <?php endif; ?>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($user['name'] ?? '—') ?></strong></td>
                            <td><?= htmlspecialchars($user['email'] ?? '—') ?></td>
                            <td><?= htmlspecialchars($user['address'] ?? '—') ?></td>
                            <td>
                                <?php $role = $user['role'] ?? 'client'; ?>
                                <span class="role-badge role-badge--<?= htmlspecialchars($role) ?>">
                                    <?= htmlspecialchars($role) ?>
                                </span>
                            </td>
                            <?php if (!empty($user['created_at'])): ?>
                                <td><?= htmlspecialchars(date('d/m/Y', strtotime($user['created_at']))) ?></td>
                            <?php endif; ?>
                            <td>
                                <div class="admin-table-actions">
                                    <!-- Pas de route adminEditUser dans le routeur : édition non disponible pour l'instant -->
                                    <form action="<?= BASE_URL ?>?action=adminDeleteUser" method="post">
                                        <input type="hidden" name="id" value="<?= (int) $user['id'] ?>">
                                        <button type="submit" class="admin-btn-icon danger"
                                                data-confirm="Supprimer définitivement cet utilisateur ?">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    <?php endif; ?>
</div>

<?php include( INCLUDE_PATH . "/footer.php"); ?>