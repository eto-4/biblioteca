<div class="demo-magic-container">

    <h1 class="demo-title">Demostració de Mètodes Màgics</h1>

    <section class="demo-section">
        <h2 class="demo-subtitle">__toString()</h2>
        <div class="demo-output">
            <?php 
            $materials = $biblioteca->getMaterials();
            $unMaterial = reset($materials);

            if ($unMaterial) {
                echo "<pre class='code-block'>" . htmlspecialchars((string)$unMaterial) . "</pre>";
            } else {
                echo "<p class='no-data'>No hi ha materials per mostrar.</p>";
            }
            ?>
        </div>
    </section>

    <section class="demo-section">
        <h2 class="demo-subtitle">__get i __set</h2>
        <div class="demo-output">
            <?php
            $usuaris = $biblioteca->getUsuaris();
            $u = reset($usuaris);

            if ($u) {
                $atribut = "Valor dinàmic";
                $u->atributInexistent = $atribut;

                $valor = $u->atributInexistent;
                echo "<p class='highlight'>Atribut llegit: " . htmlspecialchars($valor) . "</p>";
            } else {
                echo "<p class='no-data'>No hi ha usuaris per mostrar.</p>";
            }
            ?>
        </div>
    </section>

    <section class="demo-section">
        <h2 class="demo-subtitle">__call()</h2>
        <div class="demo-output">
            <?php 
            if (method_exists($biblioteca, '__call')) {
                $llibres = $biblioteca->getLlibres();
                echo "<p class='highlight'>Total de llibres trobats via __call(): " . count($llibres) . "</p>";
            } else {
                echo "<p class='no-data'>Mètode __call() no implementat a Biblioteca.</p>";
            }
            ?>
        </div>
    </section>

    <section class="demo-section">
        <h2 class="demo-subtitle">Explicació</h2>
        <ul class="demo-list">
            <li><strong>__toString()</strong>: convertir un objecte a text.</li>
            <li><strong>__get()</strong>: accés a propietats inexistents.</li>
            <li><strong>__set()</strong>: assignació a propietats inexistents.</li>
            <li><strong>__call()</strong>: crida de mètodes inexistents però reconeguts per patrons com getLlibres().</li>
        </ul>
    </section>

</div>