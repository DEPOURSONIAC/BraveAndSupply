<div class="account-section">

    <!-- Section header -->
    <div class="account-section-header">

        <h5>Activité du compte</h5>

        <span class="account-table-count">
            Session(s) active(s)
        </span>

    </div>


    <!-- Session information -->
    <div class="account-session-info">

        <div class="account-session-header">

            <div>

                <span class="account-session-label">
                    Dernière activité
                </span>

                <h3>
                    Connexion utilisateur
                </h3>

            </div>

            <span class="account-session-status">
                Active
            </span>

        </div>


        <!-- Activity -->
        <div class="account-session-activity">

            <div class="account-session-row">

                <div class="account-session-icon">
                    -
                </div>

                <div class="account-session-content">

                    <strong>
                        Connexion détectée
                    </strong>

                    <span>
                        Une session utilisateur est actuellement active.
                    </span>

                </div>

            </div>


            <div class="account-session-row">

                <div class="account-session-icon">
                    -
                </div>

                <div class="account-session-content">

                    <strong>
                        Identifiant de session
                    </strong>

                    <?php if (!empty($session_id)): ?>

                        <code class="account-session-id">
                            <?= htmlspecialchars($session_id, ENT_QUOTES, 'UTF-8') ?>
                        </code>

                    <?php else: ?>

                        <span>
                            Aucun identifiant de session disponible.
                        </span>

                    <?php endif; ?>

                </div>

            </div>

        </div>


        <!-- Technical information -->
        <div class="account-session-details">

            <div>

                <span>
                    Statut
                </span>

                <strong>
                    Active
                </strong>

            </div>


            <div>

                <span>
                    Service
                </span>

                <strong>
                    Authentication
                </strong>

            </div>


            <div>

                <span>
                    Type
                </span>

                <strong>
                    PHP Session
                </strong>

            </div>

        </div>


        <!-- Warning -->
        <div class="account-session-warning">

            <strong>
                Informations techniques
            </strong>

            <p>
                Ces informations sont normalement réservées aux opérations
                de maintenance et de diagnostic.
            </p>

        </div>

    </div>

</div>