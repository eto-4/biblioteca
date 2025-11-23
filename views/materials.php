<table class="table materials-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Títol</th>
            <th>Tipus</th>
            <th>Disponible</th>
            <th>Accions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($biblioteca->getMaterials() as $m): ?>
            <tr>
                <td><?= $m->getId(); ?></td>
                <td><?= $m->getTitol(); ?></td>
                <td><?= $m->getTipus(); ?></td>
                <td><?= $m->isDisponible() ? "Sí" : "No"; ?></td>
                <td>
                    <a href="index.php?page=material_detall&id=<?= $m->getId(); ?>">Veure</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>