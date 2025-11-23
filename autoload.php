<?php
/**
 * Autoloading manual estilo PSR-4
 *
 * Carrega automàticament les classes, interfaces, traits i excepcions segons la seva carpeta.
 */
spl_autoload_register(function ($class) {
    $baseDir = __DIR__ . '/';
    $paths = [
        'classes/' . $class . '.php',
        'interfaces/' . $class . '.php',
        'traits/' . $class . '.php',
        'exceptions/' . $class . '.php',
    ];

    foreach ($paths as $file) {
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }

    // Opcional: llançar error si no es troba la classe
    throw new Exception("No s'ha pogut carregar la classe: $class");
});
