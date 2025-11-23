<h1>Usuaris</h1>

<table class="table">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Email</th>
            <th>Accions</th>
        </tr>
    </thead>
    <tbody>

    <?php foreach ($biblioteca->getUsuaris() as $u): ?>
        <tr>
            <td><?= htmlspecialchars($u->nom); ?></td>
            <td><?= htmlspecialchars($u->email); ?></td>
            <td>
                <a href="index.php?page=usuari_detall&nom=<?= urlencode($u->nom); ?>">Veure</a>
            </td>
        </tr>
    <?php endforeach; ?>

    </tbody>
</table>