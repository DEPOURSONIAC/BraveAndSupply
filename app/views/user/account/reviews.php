            <!-- AJOUTER UN AVIS -->
            <div class="account-review-form">

                <div class="account-section-header">
                    <h5>Donner mon avis</h5>
                </div>

                <form action="<?= BASE_URL ?>?action=createReview" method="POST">

                    <div class="form-group">
                        <label for="comment">Votre avis</label>

                        <textarea id="comment" name="comment" rows="5" class="form-control" placeholder="Partagez votre expérience..." required>
                        </textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Publier mon avis
                    </button>

                </form>

            </div>

            <!-- AVIS -->
            <div class="account-section">

                <div class="account-section-header">
                    <h5>Mes avis</h5>
                    <span class="account-table-count"><?= count($reviews) ?> avis publié(s)</span>
                </div>

                <?php if (empty($reviews)): ?>

                    <div class="account-empty">
                        <p>Vous n'avez pas encore publié d'avis.</p>
                    </div>

                <?php else: ?>

                    <div class="account-review-list">
                        <?php foreach ($reviews as $review): ?>
                            <div class="account-review-card">
                                <p class="account-review-comment">
                                    <?= htmlspecialchars($review['comment'], ENT_QUOTES, 'UTF-8') ?>
                                </p>

                                    <form action="<?= BASE_URL ?>?action=removeReview" method="POST">

                                        <div class="form-group">

                                            <input type="hidden" name="review_id" value="<?= (int) $review['id'] ?>">

                                        </div>

                                        <button type="submit" class="btn btn-primary">
                                            Supprimer
                                        </button>

                                    </form>

                                </div>

                            </div>
                        <?php endforeach; ?>
                    </div>

                <?php endif; ?>

            </div>