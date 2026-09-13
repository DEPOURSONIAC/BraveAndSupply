<main class="pt-5">
  
    <!-- Products Area -->
    <section class="section" id="products">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-heading">
                        <h2>Nos Produits</h2>
                        <span>Tous les produits disponibles</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">

            <?php foreach ($products as $product): ?>

                    <div class="col-lg-4">
                        <div class="item">

                            <div class="thumb ratio ratio-4x3">

                                <div class="hover-content">
                                    <ul>
                                        <li>
                                            <a href="<?= BASE_URL ?>?action=product&id=<?= (int) $product['id'] ?>">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </li>

                                        <li>
                                            <form action="<?= BASE_URL ?>?action=addToFavorite" method="post" class="product-action-form">
                                                <input type="hidden" name="product_id" value="<?= (int) $product['id'] ?>" >

                                                <button type="submit"class="product-action-button">
                                                    <i class="fa fa-star"></i>
                                                </button>
                                            </form>
                                        </li>

                                        <li>
                                            <form action="<?= BASE_URL ?>?action=addToCart" method="post" class="product-action-form">
                                                <input type="hidden" name="product_id" value="<?= (int) $product['id'] ?>">

                                                <input type="hidden" name="quantity" value="1" >

                                                <button type="submit" class="product-action-button">
                                                    <i class="fa fa-shopping-cart"></i>
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>

                                <img src="<?= BASE_URL ?>assets/images/products/<?= htmlspecialchars($product['image'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?>">

                            </div>

                            <div class="down-content">
                                <h4>
                                    <?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?>
                                </h4>

                                <span>
                                    <?= number_format($product['price'], 2, ',', ' ') ?> €
                                </span>
                            </div>

                        </div>
                    </div>

                <?php endforeach; ?>

            </div>

        </div>

    </section>
</main>