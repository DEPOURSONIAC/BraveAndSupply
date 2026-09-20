<!-- Checkout -->
<div class="account-section">

    <div class="account-section-header">

        <h5>Passer la commande</h5>

        <span class="account-table-count">
            <?= $cart_count ?> article(s)
        </span>

    </div>


    <!-- Order summary -->
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

                <?php foreach ($products as $product): ?>

                    <tr>

                        <!-- Product -->
                        <td>

                            <div class="account-table-product">

                                <img src="<?= BASE_URL ?>assets/images/products/<?= htmlspecialchars($product['image'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?>" class="account-table-thumb">

                                <span>
                                    <?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?>
                                </span>

                            </div>

                        </td>


                        <!-- Price -->
                        <td style="color: black;">

                            <?= htmlspecialchars(number_format((float) $product['price'], 2, ',', ' '), ENT_QUOTES, 'UTF-8') ?> €

                        </td>


                        <!-- Quantity -->
                        <td>

                            <?= (int) $product['quantity'] ?>

                        </td>


                        <!-- Product's total -->
                        <td>

                            <strong style="color: black;">

                                <?= htmlspecialchars(number_format((float) $product['total_by_product'], 2, ',', ' '), ENT_QUOTES, 'UTF-8') ?> €

                            </strong>

                        </td>

                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    </div>


    <!-- Order summary -->
    <div class="account-cart-summary">

        <?php if (!empty($coupon)): ?>

            <!-- Coupon -->
            <div>

                <span>
                    Code promo :
                    <?= htmlspecialchars($coupon['code'], ENT_QUOTES, 'UTF-8') ?>
                </span>

            </div>

        <?php endif; ?>


        <?php if ($discount > 0): ?>

            <!-- Discount -->
            <div>

                <span>
                    Réduction
                </span>

                <strong style="color: black;">
                    -<?= number_format((float) $discount, 2, ',', ' ') ?> €
                </strong>

            </div>

        <?php endif; ?>


        <!-- Total -->
        <div>

            <span>
                Total
            </span>

            <strong id="checkout_total" style="color: black;">

                <?= htmlspecialchars(number_format((float) $total, 2, ',', ' '), ENT_QUOTES, 'UTF-8') ?> €

            </strong>

        </div>


        <!-- Payment -->
        <form action="<?= BASE_URL ?>?action=paypalCreateOrder" method="POST" class="paypal-form">
            <button type="submit" class="paypal-button">
                <span class="paypal-button__logo">PayPal</span>
            </button>
        </form>

    </div>


    <!-- Return to cart -->
    <div>

        <a href="<?= BASE_URL ?>?action=account" class="btn-secondary">
            Retour au account
        </a>

    </div>

</div>