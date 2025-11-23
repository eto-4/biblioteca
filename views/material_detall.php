<?php
$id = $_GET['id'] ?? null;

$mat = ($id) ? $biblioteca->cercarPerId((int)$id) : null;

if (!$mat) {
    echo "<h2>Material no trobat</h2>";
    return;
}
?>
<div class="materials-table-wrapper">
    <div class="material-detail">
        <p><strong>ID:</strong> <?= $mat->getId(); ?></p>
        <p><strong>Títol:</strong> <?= $mat->getTitol(); ?></p>
        <p><strong>Tipus:</strong> <?= $mat->getTipus(); ?></p>
        <p><strong>Disponible:</strong> <?= $mat->isDisponible() ? "Sí" : "No"; ?></p>
    
        <?php if ($mat instanceof Reservable): ?>
            <p><strong>Reservat:</strong> <?= $mat->estaReservat() ? "Sí" : "No"; ?></p>
        <?php endif; ?>
    
        <a href="index.php?page=materials">Tornar</a>
    </div>
</div>
