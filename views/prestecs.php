<h1>Préstecs</h1>

<table class="table reservables-table">
    <thead>
        <tr>
            <th>ID Material</th>
            <th>Títol</th>
            <th>Usuari</th>
            <th>Estat</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($biblioteca->getMaterials() as $m): ?>
        <?php if ($m instanceof Reservable && $m->estaReservat()): ?>
            <tr>
                <td><?= $m->getId(); ?></td>
                <td><?= htmlspecialchars($m->getTitol()); ?></td>
                <td><?= htmlspecialchars($m->getUsuariReserva()); ?></td>
                <td class="status reserved">Reservat</td>
            </tr>
        <?php endif; ?>
    <?php endforeach; ?>
    </tbody>
</table>