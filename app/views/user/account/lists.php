<div class="account-section-header">
    <h5>Mes listes</h5>
</div>

<?php if (!empty($lists)): ?>

    <div class="account-order">

        <?php foreach ($lists as $list): ?>

            <div class="account-order-box list-box">

                <div>
                    <span>Nom de la liste</span>

                    <strong>
                        <?= htmlspecialchars($list['name'] ?? 'Sans nom', ENT_QUOTES, 'UTF-8') ?>
                    </strong>
                </div>

                <div class="list-box-actions">

                    <a href="<?= BASE_URL ?>?action=list&id=<?= (int) $list['id'] ?>" class="account-table-link">
                        Ouvrir la liste ->
                    </a>

                    <form action="<?= BASE_URL ?>?action=deleteList" method="POST" class="list-delete-form" data-list-id="<?= (int) $list['id'] ?>">
                        <input type="hidden" name="list_id" value="<?= (int) $list['id'] ?>">

                        <button type="submit" class="account-table-remove" title="Supprimer la liste" >
                            <i class="fa fa-trash"></i>
                            Supprimer
                        </button>
                    </form>



                </div>

            </div>

        <?php endforeach; ?>

    </div>

<?php else: ?>

    <div class="account-empty">
        <p>Vous n'avez pas encore créé de liste.</p>
    </div>

<?php endif; ?>


<!-- Creatin a new list -->
<div class="account-section list-create">

    <div class="account-section-header">
        <h5>Créer une nouvelle liste</h5>
    </div>

    <form action="<?= BASE_URL ?>?action=createList" method="POST" class="list-create-form" data-lists-url="<?= BASE_URL ?>?action=lists">

        <input type="text" name="name" class="account-form-input" placeholder="Nom de la liste" maxlength="100" required>

        <button type="submit" class="btn-premium">
            Créer
        </button>

    </form>

</div>