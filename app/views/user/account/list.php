<div class="order-page container">

    <a href="<?= BASE_URL ?>?action=account" class="order-back-link">
        &lt;- Retour au menu account
    </a>

    <div class="account-section-header">

        <h5>Contenu de la liste</h5>

        <span class="account-table-count">
            <?= count($products ?? []) ?> produit(s)
        </span>

    </div>


    <?php if (!empty($products)): ?>
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

                    <?php foreach ($products as $product): ?>

                        <?php $productId = (int) $product['id']; ?>

                        <tr id="list-product-<?= $productId ?>" data-product-id="<?= $productId ?>">

                            <!-- Product -->
                            <td>

                                <div class="account-table-product">

                                    <img src="<?= BASE_URL ?>assets/images/products/<?= !empty($product['image']) ? htmlspecialchars($product['image'], ENT_QUOTES, 'UTF-8') : 'no-image.jpg' ?>" alt="<?= htmlspecialchars( $product['name'] ?? 'Produit', ENT_QUOTES, 'UTF-8') ?>" class="account-table-thumb">

                                    <span>
                                        <?= htmlspecialchars($product['name'] ?? 'Produit', ENT_QUOTES, 'UTF-8') ?>
                                    </span>

                                </div>

                            </td>


                            <!-- Price -->
                            <td style="color: black;">

                                <?php if (isset($product['price'])): ?>

                                    <?= htmlspecialchars($product['price'], ENT_QUOTES,'UTF-8') ?>€

                                <?php else: ?>
                                    —
                                <?php endif; ?>

                            </td>


                            <!-- Remove -->
                            <td>

                                <form action="<?= BASE_URL ?>?action=removeFromList" method="POST" class="list-item-remove-form">
                                    <input type="hidden" name="product_id" value="<?= $productId ?>">

                                    <input type="hidden" name="list_id" value="<?= (int) $list_id ?>">

                                    <button type="submit" class="account-table-remove">
                                        <i class="fa fa-times"></i>
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
            <p>
                Cette liste ne contient aucun produit pour le moment.
            </p>
        </div>

    <?php endif; ?>

</div>
