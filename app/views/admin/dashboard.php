<?php include(INCLUDE_PATH . "/header.php"); ?>

<div class="admin-stats-grid">



<!-- ========================================================= -->
<!-- Chiffre d'affaires -->
<!-- ========================================================= -->

<div class="admin-panel">

    <div class="admin-panel-head">
        <h2>Chiffre d'affaires</h2>
    </div>


    <?php if (empty($revenue_data)): ?>

        <div class="account-empty admin-chart-empty">
            <p>
                Aucune donnée de chiffre d'affaires disponible pour le moment.
            </p>
        </div>

    <?php else: ?>

        <?php
        /*
         * Préparation des données du graphique.
         * On regroupe le chiffre d'affaires par jour.
         */

        $chart_points = array();

        foreach ($revenue_data as $row) {

            if (empty($row['created_at'])) {
                continue;
            }

            $day = substr($row['created_at'], 0, 10);

            if (!isset($chart_points[$day])) {
                $chart_points[$day] = 0;
            }

            $chart_points[$day] += (float) $row['total_price'];
        }

        ksort($chart_points);


        $labels = array_keys($chart_points);
        $values = array_values($chart_points);
        $count = count($values);


        /*
         * Si aucune donnée valide n'a été trouvée,
         * on évite de continuer avec un tableau vide.
         */

        if ($count > 0) {

            $max = max($values);

            if ($max <= 0) {
                $max = 1;
            }


            /*
             * Dimensions du graphique.
             */

            $svg_w = 900;
            $svg_h = 260;

            $pad_l = 10;
            $pad_r = 10;
            $pad_t = 20;
            $pad_b = 30;

            $chart_w = $svg_w - $pad_l - $pad_r;
            $chart_h = $svg_h - $pad_t - $pad_b;


            /*
             * Distance entre les points.
             */

            if ($count > 1) {
                $step = $chart_w / ($count - 1);
            } else {
                $step = 0;
            }


            /*
             * Calcul des coordonnées.
             */

            $coords = array();

            foreach ($values as $i => $value) {

                $x = $pad_l + ($step * $i);

                $y = $pad_t
                    + $chart_h
                    - (($value / $max) * $chart_h);

                $coords[] = array($x, $y);
            }


            /*
             * Ligne du graphique.
             */

            $line_points = '';

            foreach ($coords as $point) {

                if ($line_points !== '') {
                    $line_points .= ' ';
                }

                $line_points .= $point[0] . ',' . $point[1];
            }


            /*
             * Zone sous la courbe.
             */

            $baseline_y = $pad_t + $chart_h;

            $area_points = '';

            if ($count > 0) {

                $area_points = $line_points
                    . ' ' . $coords[$count - 1][0] . ',' . $baseline_y
                    . ' ' . $coords[0][0] . ',' . $baseline_y;
            }


            /*
             * Nombre de labels affichés sur l'axe.
             * Maximum environ 7 labels.
             */

            $label_step = max(
                1,
                (int) ceil($count / 7)
            );
        }
        ?>


        <?php if ($count > 0): ?>

            <div class="admin-chart">

                <svg
                    viewBox="0 0 <?= $svg_w ?> <?= $svg_h ?>"
                    preserveAspectRatio="none"
                >

                    <!-- Axe horizontal -->
                    <line
                        class="chart-axis"
                        x1="<?= $pad_l ?>"
                        y1="<?= $pad_t + $chart_h ?>"
                        x2="<?= $svg_w - $pad_r ?>"
                        y2="<?= $pad_t + $chart_h ?>"
                    ></line>


                    <!-- Zone sous la courbe -->
                    <?php if ($area_points !== ''): ?>

                        <polygon
                            class="chart-area"
                            points="<?= htmlspecialchars($area_points, ENT_QUOTES, 'UTF-8') ?>"
                        ></polygon>

                    <?php endif; ?>


                    <!-- Ligne -->
                    <?php if ($line_points !== ''): ?>

                        <polyline
                            class="chart-line"
                            points="<?= htmlspecialchars($line_points, ENT_QUOTES, 'UTF-8') ?>"
                        ></polyline>

                    <?php endif; ?>


                    <!-- Points et labels -->

                    <?php foreach ($coords as $i => $point): ?>

                        <circle
                            class="chart-dot"
                            cx="<?= $point[0] ?>"
                            cy="<?= $point[1] ?>"
                            r="3"
                        ></circle>


                        <?php if ($i % $label_step === 0 || $i === $count - 1): ?>

                            <text
                                class="chart-label"
                                x="<?= $point[0] ?>"
                                y="<?= $svg_h - 8 ?>"
                                text-anchor="middle"
                            >
                                <?= htmlspecialchars(
                                    date('d/m', strtotime($labels[$i])),
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </text>

                        <?php endif; ?>

                    <?php endforeach; ?>

                </svg>

            </div>

        <?php else: ?>

            <div class="account-empty admin-chart-empty">
                <p>
                    Aucune donnée de chiffre d'affaires disponible pour le moment.
                </p>
            </div>

        <?php endif; ?>

    <?php endif; ?>

</div>

    <div class="admin-stat-card">
        <div class="admin-stat-icon">
            <i class="fa fa-users"></i>
        </div>

        <div>
            <div class="admin-stat-value">
                <?= (int) ($stats['users'] ?? 0) ?>
            </div>

            <div class="admin-stat-label">
                Utilisateurs
            </div>
        </div>
    </div>

    <div class="admin-stat-card">
        <div class="admin-stat-icon">
            <i class="fa fa-euro"></i>
        </div>

        <div>
            <div class="admin-stat-value">
                <?= number_format((float) ($stats['revenue'] ?? 0), 2, ',', ' ') ?> €
            </div>

            <div class="admin-stat-label">
                Chiffre d'affaires
            </div>
        </div>
    </div>

    <div class="admin-stat-card">
        <div class="admin-stat-icon">
            <i class="fa fa-shopping-bag"></i>
        </div>

        <div>
            <div class="admin-stat-value">
                <?= (int) ($stats['orders'] ?? 0) ?>
            </div>

            <div class="admin-stat-label">
                Commandes
            </div>
        </div>
    </div>
    

</div>


<!-- ========================================================= -->
<!-- Dernières commandes -->
<!-- ========================================================= -->

<div class="admin-panel">

    <div class="admin-panel-head">

        <h2>Dernières commandes</h2>

        <a
            href="<?= BASE_URL ?>?action=adminOrders"
            class="account-table-link"
        >
            Voir tout
        </a>

    </div>


    <?php if (empty($recent_orders)): ?>

        <div class="account-empty">
            <p>Aucune commande pour le moment.</p>
        </div>

    <?php else: ?>

        <div class="table-responsive">

            <table class="account-table">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Client</th>
                        <th>Montant</th>
                        <th>Statut</th>
                        <th>Date</th>
                        <th></th>
                    </tr>
                </thead>


                <tbody>

                    <?php foreach ($recent_orders as $order): ?>

                        <tr>

                            <td>
                                #<?= (int) ($order['id'] ?? 0) ?>
                            </td>


                            <td>

                                <?= htmlspecialchars(
                                    $order['user_name'] ?? '—',
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                                <?php if (!empty($order['user_email'])): ?>

                                    <br>

                                    <span class="admin-text-muted">
                                        <?= htmlspecialchars(
                                            $order['user_email'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                                    </span>

                                <?php endif; ?>

                            </td>


                            <td>
                                <?= number_format(
                                    (float) ($order['total_price'] ?? 0),
                                    2,
                                    ',',
                                    ' '
                                ) ?>
                                €
                            </td>


                            <td>

                                <?php
                                $status = $order['status'] ?? 'pending';
                                ?>

                                <span
                                    class="order-status order-status--<?= htmlspecialchars(
                                        $status,
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>"
                                >
                                    <?= htmlspecialchars(
                                        $status,
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>
                                </span>

                            </td>


                            <td>

                                <?php if (!empty($order['created_at'])): ?>

                                    <?= htmlspecialchars(
                                        date(
                                            'd/m/Y',
                                            strtotime($order['created_at'])
                                        ),
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>

                                <?php else: ?>

                                    —

                                <?php endif; ?>

                            </td>


                            <td>

                                <a
                                    href="<?= BASE_URL ?>?action=adminOrder&id=<?= (int) ($order['id'] ?? 0) ?>"
                                    class="admin-btn-icon"
                                >
                                    <i class="fa fa-eye"></i>
                                </a>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    <?php endif; ?>

    

</div>




<?php include(INCLUDE_PATH . "/footer.php"); ?>