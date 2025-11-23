<?php
$nom = filter_input(INPUT_GET, 'nom', FILTER_SANITIZE_STRING);
if (!$nom) {
    echo "<h2>Usuari no indicat</h2>";
    return;
}

$u = $biblioteca->cercarUsuari($nom);

if (!$u) {
    echo "<h2>Usuari no trobat</h2>";
    return;
}
?>
<div class="user-detail-wrapper">
    <div class="user-detail">
        <h1>Detall d'Usuari</h1>
    
        <p><strong>Nom:</strong> <?= htmlspecialchars($u->nom); ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($u->email); ?></p>
    
        <h2>Préstecs Actius</h2>
        <p>(Encara no implementat)</p>
    
        <a href="index.php?page=usuaris">Tornar</a>
    </div>
</div>