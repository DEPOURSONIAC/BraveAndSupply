<main id="account-main">

    <section class="section">

        <div class="container account-container">

            <!-- Profil -->
            <div class="account-profile">

                <div class="account-avatar">
                    <?= htmlspecialchars(strtoupper(substr($user['name'], 0, 1)), ENT_QUOTES, 'UTF-8') ?>
                </div>

                <div>
                    <h4 class="mb-1">
                        <?= htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8') ?>
                    </h4>

                    <p class="account-email mb-0">
                        <?= htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8') ?>
                    </p>
                </div>

            </div>

            <!-- Content -->
            <section id="account-content">

                <div class="account-section">

                    <div class="account-section-header">
                        <h5>Modifier mes informations</h5>

                        <a href="<?= BASE_URL ?>?action=account">
                            Retour
                        </a>
                    </div>

                    <form action="<?= BASE_URL ?>?action=accountEdit" method="POST" class="account-edit-form">

                        <!-- Name -->
                        <div class="mb-4">
                            <label for="name">Nom</label>

                            <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8') ?>" required>
                        </div>

                        <!-- Mail -->
                        <div class="mb-4">
                            <label for="email">Adresse e-mail</label>

                            <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8') ?>" required>
                        </div>

                        <!-- Adress -->
                        <div class="mb-4">
                            <label for="address">Adresse</label>

                           <textarea id="address" name="address" rows="3" required><?= htmlspecialchars(trim($user['address']), ENT_QUOTES, 'UTF-8') ?></textarea>
                           
                        </div>

                        <!-- Password -->
                        <div class="account-password-section">

                            <h6>Modifier le mot de passe</h6>

                            <p>
                                Laissez ce champ vide si vous ne souhaitez pas modifier votre mot de passe.
                            </p>

                            <label for="new_password">
                                Nouveau mot de passe
                            </label>

                            <input type="password" id="new_password" name="new_password" autocomplete="new-password">

                        </div>

                        <!-- Actions -->
                        <div class="account-form-actions">

                            <a href="<?= BASE_URL ?>?action=account" class="btn-secondary">
                                Annuler
                            </a>

                            <button type="submit" class="btn-primary">
                                Enregistrer les modifications
                            </button>

                        </div>

                    </form>

                </div>

            </section>

        </div>

    </section>

</main>