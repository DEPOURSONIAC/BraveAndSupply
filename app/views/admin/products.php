<?php include(INCLUDE_PATH . "/header.php"); ?>

<div class="admin-panel admin-products">

    <div class="admin-panel-head">
        <h2>Produits (<?= count($products) ?>)</h2>
    </div>

    <?php if (empty($products)): ?>

        <div class="account-empty">
            <p>Aucun produit enregistré.</p>
        </div>

        <!-- Bouton même s'il n'y a aucun produit -->
        <div class="admin-products-add">
            <a
                href="javascript:;"
                class="admin-btn-primary"
                data-modal-open="modal-add-product"
            >
                <i class="fa fa-plus"></i>
                Ajouter un produit
            </a>
        </div>

    <?php else: ?>

        <div class="table-responsive">
            <table class="account-table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Prix</th>
                        <th>Stock</th>
                        <th>Catégorie</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($products as $product): ?>

                        <tr>
                            <td>
                                <?php if (!empty($product['image'])): ?>
                                    <img
                                        src="<?= BASE_URL ?>assets/images/products/<?= htmlspecialchars($product['image'], ENT_QUOTES, 'UTF-8') ?>"
                                        alt="<?= htmlspecialchars($product['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                        class="admin-table-thumb"
                                    >
                                <?php else: ?>
                                    <div class="admin-table-thumb"></div>
                                <?php endif; ?>
                            </td>

                            <td>
                                <strong>
                                    <?= htmlspecialchars($product['name'] ?? '—', ENT_QUOTES, 'UTF-8') ?>
                                </strong>
                            </td>

                            <td>
                                <span class="admin-text-muted">
                                    <?= htmlspecialchars($product['description'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                                </span>
                            </td>

                            <td>
                                <?= number_format((float) ($product['price'] ?? 0), 2, ',', ' ') ?> €
                            </td>

                            <td>
                                <?= (int) ($product['stock'] ?? 0) ?>
                            </td>

                            <td>
                                <span class="admin-text-muted">
                                    Cat. #<?= (int) ($product['category_id'] ?? 0) ?>
                                </span>
                            </td>

                            <td>
                                <div class="admin-table-actions">

                                    <!-- Modifier -->
                                    <a
                                        href="javascript:;"
                                        class="admin-btn-icon"
                                        data-modal-open="modal-edit-product"
                                        data-product-id="<?= (int) $product['id'] ?>"
                                        data-product-name="<?= htmlspecialchars($product['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                        data-product-description="<?= htmlspecialchars($product['description'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                        data-product-price="<?= htmlspecialchars((string) ($product['price'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"
                                        data-product-stock="<?= htmlspecialchars((string) ($product['stock'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"
                                    >
                                        <i class="fa fa-pencil"></i>
                                    </a>

                                    <!-- Supprimer -->
                                    <form
                                        action="<?= BASE_URL ?>?action=adminDeleteProduct"
                                        method="post"
                                    >
                                        <input
                                            type="hidden"
                                            name="id"
                                            value="<?= (int) $product['id'] ?>"
                                        >

                                        <button
                                            type="submit"
                                            class="admin-btn-icon danger"
                                            data-confirm="Supprimer ce produit ?"
                                        >
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

        <!-- Bouton après les produits -->
        <div class="admin-products-add">
            <a
                href="javascript:;"
                class="admin-btn-primary"
                data-modal-open="modal-add-product"
            >
                <i class="fa fa-plus"></i>
                Ajouter un produit
            </a>
        </div>

    <?php endif; ?>

</div>


<!-- ========================================================= -->
<!-- Modal Ajouter un produit -->
<!-- ========================================================= -->

<div class="admin-modal" id="modal-add-product">

    <div class="admin-modal-panel">

        <div class="admin-modal-head">
            <h3>Ajouter un produit</h3>

            <button
                type="button"
                class="admin-modal-close"
                data-modal-close
            >
                &times;
            </button>
        </div>

        <form
            action="<?= BASE_URL ?>?action=adminAddProduct"
            method="post"
            class="account-edit-form"
        >

            <div class="admin-form-row">
                <label for="add-name">Nom</label>

                <input
                    type="text"
                    id="add-name"
                    name="name"
                    required
                >
            </div>

            <div class="admin-form-row">
                <label for="add-description">Description</label>

                <textarea
                    id="add-description"
                    name="description"
                    required
                ></textarea>
            </div>

            <div class="admin-form-row">
                <label for="add-price">Prix (€)</label>

                <input
                    type="number"
                    id="add-price"
                    name="price"
                    step="0.01"
                    min="0.01"
                    required
                >
            </div>

            <div class="admin-form-row">
                <label for="add-quantity">Stock</label>

                <input
                    type="number"
                    id="add-quantity"
                    name="quantity"
                    step="1"
                    min="0"
                    required
                >
            </div>

            <p class="admin-text-muted">
                Image et catégorie non gérées pour l'instant
            </p>

            <div class="account-form-actions">
                <button
                    type="submit"
                    class="admin-btn-primary"
                >
                    Créer
                </button>
            </div>

        </form>

    </div>

</div>


<!-- ========================================================= -->
<!-- Modal Modifier un produit -->
<!-- ========================================================= -->

<div class="admin-modal" id="modal-edit-product">

    <div class="admin-modal-panel">

        <div class="admin-modal-head">
            <h3>Modifier le produit</h3>

            <button
                type="button"
                class="admin-modal-close"
                data-modal-close
            >
                &times;
            </button>
        </div>

        <form
            action="<?= BASE_URL ?>?action=adminEditProduct"
            method="post"
            class="account-edit-form"
        >

            <input
                type="hidden"
                name="id"
                id="edit-id"
            >

            <div class="admin-form-row">
                <label for="edit-name">Nom</label>

                <input
                    type="text"
                    id="edit-name"
                    name="name"
                    required
                >
            </div>

            <div class="admin-form-row">
                <label for="edit-description">Description</label>

                <textarea
                    id="edit-description"
                    name="description"
                    required
                ></textarea>
            </div>

            <div class="admin-form-row">
                <label for="edit-price">Prix (€)</label>

                <input
                    type="number"
                    id="edit-price"
                    name="price"
                    step="0.01"
                    min="0.01"
                    required
                >
            </div>

            <div class="admin-form-row">
                <label for="edit-quantity">Stock</label>

                <input
                    type="number"
                    id="edit-quantity"
                    name="quantity"
                    step="1"
                    min="0"
                    required
                >
            </div>

            <div class="account-form-actions">

                <button
                    type="button"
                    class="admin-btn-icon"
                    data-modal-close
                >
                    Annuler
                </button>

                <button
                    type="submit"
                    class="admin-btn-primary"
                >
                    Enregistrer
                </button>

            </div>

        </form>

    </div>

</div>


<?php include(INCLUDE_PATH . "/footer.php"); ?>