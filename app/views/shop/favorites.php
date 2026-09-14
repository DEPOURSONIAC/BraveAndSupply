    <div class="container favorites-page">

        <div class="account-section-header">
            <h5>Mes favoris</h5>
        </div>

        <?php if (!empty($favorites)): ?>

            <div class="table-responsive">

                <table class="account-table">

                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th>Prix</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php foreach ($favorites as $product): ?>

                            <tr data-product-id="<?= (int) $product['id'] ?>">

                                <td>
                                    <a href="<?= BASE_URL ?>?action=product&id=<?= (int) $product['id'] ?>"
                                    class="account-table-product">

                                        <img src="<?= BASE_URL ?>assets/images/products/<?= htmlspecialchars($product['image'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?>" class="account-table-thumb">

                                        <span>
                                            <?= htmlspecialchars($product['name'] ?? 'Produit', ENT_QUOTES, 'UTF-8') ?>
                                        </span>

                                    </a>
                                </td>

                                <td>
                                    <?= isset($product['price']) ? number_format((float) $product['price'], 2, ',', ' ') . ' €': '—'?>
                                </td>

                                <td>

                                    <form action="<?= BASE_URL ?>?action=removeFromFavorite" method="POST" class="favorite-remove-form" data-product-id="<?= (int) $product['id'] ?>">

                                        <input type="hidden" name="product_id" value="<?= (int) $product['id'] ?>" >

                                        <button type="submit" class="account-table-remove" title="Retirer des favoris">
                                            <i class="fa fa-heart"></i>
                                            Retirer
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        <?php else: ?>

            <div class="account-empty">

                <p>Vous n'avez pas encore ajouté de favoris.</p>

                <a href="<?= BASE_URL ?>?action=catalogue" class="btn-premium">
                    Découvrir les produits
                </a>

            </div>

        <?php endif; ?>

    </div>