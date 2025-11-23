<?php
/**
 * Fitxer index.php
 * Demostració de funcionalitats de la biblioteca
 */

require_once 'autoload.php';

echo "=== Inici del Test Biblioteca ===\n\n";

// Creació de biblioteca
$biblioteca = new Biblioteca("Biblioteca Central");
echo "Biblioteca creada: " . $biblioteca->getNom() . "\n\n";

// Creació de materials
$llibre1 = new Llibre(1, "1984", "George Orwell", 1949, true, 328);
$llibre2 = new Llibre(2, "El Quijote", "Miguel de Cervantes", 1605, true, 863);
$revista1 = new Revista(3, "National Geographic", "Varios", 2023, true, 150);
$dvd1 = new DVD(4, "Matrix", "Hermanas Wachowski", 1999, true, 136);

$biblioteca->afegirMaterial($llibre1);
$biblioteca->afegirMaterial($llibre2);
$biblioteca->afegirMaterial($revista1);
$biblioteca->afegirMaterial($dvd1);

echo "Materials afegits:\n";
foreach ($biblioteca->getMaterials() as $material) {
    echo $material->__toString() . "\n";
}

// Creació d'usuaris
try {
    $usuari1 = new Usuari("Alice", "alice@example.com");
    $usuari2 = new Usuari("Bob", "bob@example.com");
    // Email invàlid per provar excepció
    $usuari3 = new Usuari("Charlie", "charlie@@example.com"); 
} catch (\InvalidArgumentException $e) {
    echo "Excepció capturada: " . $e->getMessage() . "\n";
}

// Prestar materials amb gestió d'errors
try {
    // Prestar llibre1 a Alice
    $llibre1->reservar($usuari1->__get('nom'));
    $usuari1->afegirPrestec($llibre1);
    $llibre1->registrarAccio("prestat", "Prestec a {$usuari1->__get('nom')}");
    
    // Intentar prestar el mateix llibre de nou
    if (!$llibre1->reservar($usuari2->__get('nom'))) {
        throw new MaterialJaPrestatException($llibre1->getId(), "El llibre ja està prestat.");
    }
} catch (MaterialJaPrestatException $e) {
    echo "Excepció: " . $e->__toString() . "\n";
}

// Reservar materials
$dvd1->reservar($usuari2->__get('nom'));
$dvd1->registrarAccio("reservat", "Usuari: {$usuari2->__get('nom')}");

// Mètodes màgics
echo "\n__toString usuari1: " . $usuari1->__toString() . "\n";
echo "__get nom usuari2: " . $usuari2->__get('nom') . "\n";

try {
    $usuari2->__set('email', 'nou_email@example.com'); // correcte
    echo "__set email usuari2 correcte: " . $usuari2->__get('email') . "\n";
    $usuari2->__set('email', 'invalid@@example'); // invàlid
} catch (\InvalidArgumentException $e) {
    echo "Excepció al modificar email: " . $e->getMessage() . "\n";
}

// Auditoria
echo "\nHistorial accions llibre1:\n";
print_r($llibre1->obtenirHistorial());

echo "\nHistorial accions DVD1:\n";
print_r($dvd1->obtenirHistorial());

// Estadístiques del sistema
echo "\nEstadístiques Biblioteca:\n";
print_r($biblioteca->obtenirEstadistiques());

// Serialització d'usuaris
$usuari_serialitzat = serialize($usuari1);
echo "\nUsuari1 serialitzat: $usuari_serialitzat\n";

$usuari_deserialitzat = unserialize($usuari_serialitzat);
echo "Usuari1 deserialitzat __toString: " . $usuari_deserialitzat->__toString() . "\n";

echo "\n=== Fi del Test Biblioteca ===\n";