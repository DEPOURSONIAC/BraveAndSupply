<?php require_once INCLUDE_PATH . '/header.php'; ?>

<main class="pt-5">
<div class="page">

    <div class="card">

        <h1>Créer un compte</h1>

        <p>Rejoignez-nous en quelques secondes</p>

        <?php if (!empty($errors)): ?>
            <div class="form-errors">
                <ul>
                    <?php foreach ($errors as $err): ?>
                        <li><?= htmlspecialchars($err, ENT_QUOTES, 'UTF-8') ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= BASE_URL ?>?action=register" method="POST">

            <input type="text" name="name" placeholder="Nom complet" value="<?= htmlspecialchars($old['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>" autocomplete="name" required>

            <input type="email" name="email" placeholder="Email" value="<?= htmlspecialchars($old['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>" autocomplete="email" required>

            <input type="password" name="password" placeholder="Mot de passe" autocomplete="new-password" minlength="8" required>

            <input type="password" name="password_confirm" placeholder="Confirmer le mot de passe" autocomplete="new-password" minlength="8" required>

            <input type="text" name="address" placeholder="Adresse" value="<?= htmlspecialchars($old['address'] ?? '', ENT_QUOTES, 'UTF-8') ?>" autocomplete="street-address">

            <button type="submit">
                Créer mon compte
            </button>

        </form>

        <div class="bottom">
            Déjà un compte ?
            <a href="<?= BASE_URL ?>?action=login">Se connecter</a>
        </div>

    </div>

</div>
</main>

<?php require_once INCLUDE_PATH . '/footer.php'; ?>