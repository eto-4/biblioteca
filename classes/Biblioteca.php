<?php 
require_once 'Material.php';
require_once 'Llibre.php';
require_once 'Revista.php';
require_once 'DVD.php';
require_once '../interfaces/Reservable.php';

/**
 * Classe Biblioteca
 *
 * Gestiona materials (Llibres, Revistes, DVDs) i usuaris.
 * Permet afegir, eliminar, cercar i prestar materials, així com obtenir estadístiques.
 */
class Biblioteca {

    // Propietats protegides
    private array $materials = [];
    private array $usuaris = [];
    private string $nom;

    /**
     * Constructor Biblioteca
     *
     * @param string $nom Nom de la biblioteca
     */
    public function __construct(string $nom) { $this->nom = $nom; }

    // Gestió de materials
    // ---------------------------------------------------------

    /**
     * Afegir un material a la col·lecció
     *
     * @param Material $material Material a afegir
     */
    public function afegirMaterial(Material $material): void {
        $this->materials[$material->getId()] = $material;
    }

    /**
     * Eliminar un material per ID
     *
     * @param int $id ID del material
     * @return bool True si s'ha eliminat, false si no existia
     */
    public function eliminarMaterial(int $id): bool {
        if (!isset($this->materials[$id])) return false;
        unset($this->materials[$id]);
        return true;
    }

    /**
     * Cercar materials per títol (case-insensitive)
     *
     * @param string $titol Títol a cercar
     * @return array Materials que coincideixen amb el títol
     */
    public function cercarPerTitol(string $titol): array {
        return array_filter($this->materials, fn($m) => stripos($m->getTitol(), $titol) !== false);
    }

    /**
     * Cercar materials per autor (case-insensitive)
     *
     * @param string $autor Autor a cercar
     * @return array Materials que coincideixen amb l'autor
     */
    public function cercarPerAutor(string $autor): array {
        return array_filter($this->materials, fn($m) => stripos($m->getAutor(), $autor) !== false);
    }

    /**
     * Cercar material per ID
     *
     * @param int $id ID del material
     * @return Material|null Retorna el material si existeix, sinó null
     */
    public function cercarPerId(int $id): ?Material {
        return $this->materials[$id] ?? null;
    }

    // Llistats
    // ---------------------------------------------------------

    /**
     * Llistar només materials disponibles
     *
     * @return array Materials disponibles
     */
    public function llistarDisponibles(): array {
        return array_filter($this->materials, fn($m) => $m->estaDisponible());
    }

    /**
     * Llistar només materials prestats
     *
     * @return array Materials prestats
     */
    public function llistarPrestat(): array {
        return array_filter($this->materials, fn($m) => !$m->estaDisponible());
    }

    /**
     * Filtrar materials per tipus
     *
     * @param string $tipus Tipus de material ("Llibre", "Revista", "DVD")
     * @return array Materials del tipus indicat
     */
    public function llistarPerTipus(string $tipus): array {
        return array_filter($this->materials, fn($m) => $m->getTipus() === $tipus);
    }

    // Gestió de préstecs
    // ---------------------------------------------------------

    /**
     * Prestar un material a un usuari
     *
     * @param int $materialId ID del material
     * @param string $nomUsuari Nom de l'usuari
     * @return bool True si la reserva s'ha fet correctament, false en cas contrari
     */
    public function prestarMaterial(int $materialId, string $nomUsuari): bool {
        $material = $this->cercarPerId($materialId);
        if (!$material || !$material instanceof Reservable) return false;
        if (!$material->estaReservat()) return $material->reservar($nomUsuari);
        return false;
    }

    /**
     * Retornar un material prestat
     *
     * @param int $materialId ID del material
     * @return bool True si la devolució s'ha fet correctament, false en cas contrari
     */
    public function retornarMaterial(int $materialId): bool {
        $material = $this->cercarPerId($materialId);
        if (!$material || !$material instanceof Reservable) return false;
        if ($material->estaReservat()) return $material->cancelarReserva();
        return false;
    }

    // Gestió d'usuaris
    // ---------------------------------------------------------
    
    /**
     * Afegir un usuari al sistema
     *
     * @param Usuari $usuari Usuari a afegir
     */
    public function afegirUsuari(Usuari $usuari): void {
        $this->usuaris[$usuari->getNom()] = $usuari;
    }

    /**
     * Cercar un usuari pel nom
     *
     * @param string $nom Nom de l'usuari
     * @return Usuari|null Retorna l'usuari si existeix, sinó null
     */
    public function cercarUsuari(string $nom): ?Usuari {
        return $this->usuaris[$nom] ?? null;
    }

    // Mètodes Dinàmics (__call)
    // ---------------------------------------------------------

    /**
     * Permet cridar mètodes dinàmics com getLlibres(), getRevistes(), getDVDs()
     *
     * @param string $name Nom del mètode
     * @param array $arguments Arguments del mètode
     * @return array Materials filtrats per tipus
     * @throws BadMethodCallException Si el mètode no existeix
     */
    public function __call($name, $arguments) {
        if (preg_match('/^get(Llibres|Revistes|DVDs)$/', $name, $matches)) {
            $tipus = rtrim($matches[1], 's'); // Llibres → Llibre
            return $this->llistarPerTipus($tipus);
        }
        throw new BadMethodCallException("Mètode $name no existeix.");
    }

    // Estadístiques
    // ---------------------------------------------------------
    
    /**
     * Obtenir estadístiques de la biblioteca
     *
     * @return array Array amb total de materials, disponibles, prestats i per tipus
     */
    public function obtenirEstadistiques(): array {
        $total = count($this->materials);
        $disponibles = count($this->llistarDisponibles());
        $prestats = count($this->llistarPrestat());
        $perTipus = [
            'Llibre' => count($this->llistarPerTipus('Llibre')),
            'Revista' => count($this->llistarPerTipus('Revista')),
            'DVD' => count($this->llistarPerTipus('DVD'))
        ];
        return compact('total', 'disponibles', 'prestats', 'perTipus');
    }

    // Getters - Materials, Usuaris, Nom
    // ---------------------------------------------------------
    
    /**
     * Retorna tots els materials
     *
     * @return array Materials
     */
    public function getMaterials(): array { return $this->materials; }

    /**
     * Retorna tots els usuaris
     *
     * @return array Usuaris
     */
    public function getUsuaris(): array { return $this->usuaris; }

    /**
     * Retorna el nom de la biblioteca
     *
     * @return string Nom
     */
    public function getNom(): string { return $this->nom; }
}   
?>
