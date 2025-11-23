<?php
require_once "autoload.php";
// Crear o cargar tu biblioteca (si la tienes ya construida en un DataGenerator)
$biblioteca = new Biblioteca("Biblioteca Central");

require_once __DIR__ . '/classes/init_data.php';

// Determinar la página solicitada
$page = $_GET['page'] ?? 'home';

// Incluir header
include "views/header.php";

// Cargar la vista adecuada
$viewFile = "views/" . $page . ".php";
if (file_exists($viewFile)) {
    include $viewFile;
} else {
    include "views/404.php";
}

// Incluir footer
include "views/footer.php";