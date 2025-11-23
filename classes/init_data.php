<?php
// init_data.php - Generador de dades de prova per a Biblioteca

if (!isset($biblioteca)) {
    throw new \Exception("La variable \$biblioteca no existeix. Has de crear-la abans d'incloure init_data.php");
}

// Evitar duplicar dades si ja existeixen
if (!empty($biblioteca->getMaterials()) || !empty($biblioteca->getUsuaris())) {
    return;
}

// -------------------------------
// Creació de Materials
// -------------------------------

// Llibres
$llibres = [
    new Llibre(1, "El Quixot", "Miguel de Cervantes", 1605, true, 863),
    new Llibre(2, "Les Misèrables", "Victor Hugo", 1862, true, 1463),
    new Llibre(3, "1984", "George Orwell", 1949, true, 328),
];

// Revistes
$revistes = [
    new Revista(101, "National Geographic", "Varios", 2023, true, 3),
    new Revista(102, "Science", "AAAS", 2023, true, 12),
];

// DVDs
$dvds = [
    new DVD(201, "El Senyor dels Anells: La Comunitat de l'Anell", "Peter Jackson", 2001, true, 178),
    new DVD(202, "Matrix", "Hermanas Wachowski", 1999, true, 136),
    new DVD(203, "Interstellar", "Christopher Nolan", 2014, true, 169),
];

// Afegim tots els materials a la biblioteca
foreach (array_merge($llibres, $revistes, $dvds) as $material) {
    $biblioteca->afegirMaterial($material);
}

// -------------------------------
// Creació d'Usuaris
// -------------------------------
$usuaris = [
    new Usuari("Joan", "joan@example.com"),
    new Usuari("Anna", "anna@example.com"),
    new Usuari("Pere", "pere@example.com"),
    new Usuari("Maria", "maria@domini.cat"),
];

foreach ($usuaris as $u) {
    $biblioteca->afegirUsuari($u);
}

// -------------------------------
// Simulació de Préstecs
// -------------------------------
try {
    $biblioteca->prestarMaterial(1, "Joan"); // El Quixot
    $biblioteca->prestarMaterial(2, "Anna"); // Les Misèrables
    $biblioteca->prestarMaterial(201, "Pere"); // DVD El Senyor dels Anells
} catch (Exception $e) {
    // Ignorar errors de duplicats
}

// -------------------------------
// Simulació de Reserves (només Llibres i DVDs)
// -------------------------------
try {
    $biblioteca->getMaterials()[3]->reservar("Maria");    // 1984 (ID = 3)
    $biblioteca->getMaterials()[203]->reservar("Anna");   // Interstellar (ID = 203)
} catch (Exception $e) {
    // Ignorar errors de duplicats
}

// -------------------------------
// Registrar accions a l'auditoria
// -------------------------------
foreach ($biblioteca->getMaterials() as $mat) {
    $mat->registrarAccio("creat", "Material inicialitzat amb dades de prova");
}

foreach ($biblioteca->getUsuaris() as $usu) {
    $usu->__set("email", $usu->__get("email")); // Simula acció sobre usuaris
}
?>