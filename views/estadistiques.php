<h1>Estadístiques</h1>

<?php $stats = $biblioteca->obtenirEstadistiques(); ?>

<div class="stats-grid">
    <div class="stat-card">
        <h3>Total Materials</h3>
        <span class="number"><?= $stats['total']; ?></span>
    </div>

    <div class="stat-card">
        <h3>Disponibles</h3>
        <span class="number"><?= $stats['disponibles']; ?></span>
    </div>

    <div class="stat-card">
        <h3>Prestats</h3>
        <span class="number"><?= $stats['prestats']; ?></span>
    </div>
</div>

<h2>Per Tipus</h2>

<ul class="list-group">
<?php foreach ($stats['perTipus'] as $tipus => $count): ?>
    <li class="list-item"><?= $tipus ?>: <?= $count ?></li>
<?php endforeach; ?>
</ul>