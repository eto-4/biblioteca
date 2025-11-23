<?php
$usuari_id = $_GET['usuari_id'] ?? null;
$auditoria = [];

if ($usuari_id) {
    // Filtrar historial per usuari específic
    $usuari = $biblioteca->cercarUsuari($usuari_id);
    if ($usuari) {
        foreach ($usuari->getMaterialsPrestat() as $mat) {
            foreach ($mat->obtenirHistorial() as $entrada) {
                $auditoria[] = [
                    'material' => $mat->getTitol(),
                    'tipus' => $mat->getTipus(),
                    'timestamp' => $entrada['timestamp'],
                    'accio' => $entrada['accio'],
                    'detalls' => $entrada['detalls'],
                ];
            }
        }
    } else {
        echo "<p>Usuari no trobat.</p>";
    }
} else {
    // Auditoria global: recórrer tots els materials
    $materials = $biblioteca->getMaterials();
    foreach ($materials as $mat) {
        foreach ($mat->obtenirHistorial() as $entrada) {
            $auditoria[] = [
                'material' => $mat->getTitol(),
                'tipus' => $mat->getTipus(),
                'timestamp' => $entrada['timestamp'],
                'accio' => $entrada['accio'],
                'detalls' => $entrada['detalls'],
            ];
        }
    }
}

// Ordenar per data descendent
usort($auditoria, fn($a, $b) => strtotime($b['timestamp']) - strtotime($a['timestamp']));
?>

<div class="auditoria-container">

    <h1 class="auditoria-title">Auditoria del Sistema</h1>

    <?php if (empty($auditoria)): ?>
        <p class="auditoria-no-data">No hi ha accions registrades.</p>
    <?php else: ?>
        <div class="auditoria-table-wrapper">
            <table class="auditoria-table">
                <thead>
                    <tr>
                        <th>Material</th>
                        <th>Tipus</th>
                        <th>Acció</th>
                        <th>Detalls</th>
                        <th>Data/Hora</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($auditoria as $log): ?>
                        <tr>
                            <td><?= htmlspecialchars($log['material']) ?></td>
                            <td><?= htmlspecialchars($log['tipus']) ?></td>
                            <td><?= htmlspecialchars($log['accio']) ?></td>
                            <td><?= htmlspecialchars($log['detalls']) ?></td>
                            <td><?= htmlspecialchars($log['timestamp']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>