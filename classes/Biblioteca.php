<?php
class Biblioteca {

    private array $materials = [];
    private array $usuaris = [];
    private string $nom;

    public function __construct(string $nom) { $this->nom = $nom; }

    // ----------------------
    // Materials
    // ----------------------
    public function afegirMaterial(Material $material): void {
        $this->materials[$material->getId()] = $material;
    }

    public function eliminarMaterial(int $id): bool {
        if (!isset($this->materials[$id])) return false;
        unset($this->materials[$id]);
        return true;
    }

    public function cercarPerId(int $id): ?Material {
        return $this->materials[$id] ?? null;
    }

    public function llistarDisponibles(): array {
        return array_filter($this->materials, fn($m) => $m->isDisponible());
    }

    public function llistarPrestat(): array {
        return array_filter($this->materials, fn($m) => !$m->isDisponible());
    }

    public function llistarPerTipus(string $tipus): array {
        return array_filter($this->materials, fn($m) => $m->getTipus() === $tipus);
    }

    // ----------------------
    // Préstecs
    // ----------------------
    public function prestarMaterial(int $materialId, string $nomUsuari): bool {
        $material = $this->cercarPerId($materialId);
        $usuari = $this->cercarUsuari($nomUsuari);
        if (!$material || !$usuari) return false;

        // Si el material és reservable
        if ($material instanceof Reservable) {
            if ($material->estaReservat()) return false; // ja reservat
            $material->reservar($nomUsuari);
        }

        // Marcar material com no disponible
        if (method_exists($material, 'setDisponible')) {
            $material->setDisponible(false);
        }

        // Afegir a materials prestats de l'usuari
        $usuari->afegirPrestec($material);

        return true;
    }

    public function retornarMaterial(int $materialId): bool {
        $material = $this->cercarPerId($materialId);
        if (!$material) return false;

        // Cancel·lar reserva si es possible
        if ($material instanceof Reservable && $material->estaReservat()) {
            $material->cancelarReserva();
        }

        // Marcar material com disponible
        if (method_exists($material, 'setDisponible')) {
            $material->setDisponible(true);
        }

        // Eliminar de l'usuari corresponent
        foreach ($this->usuaris as $usuari) {
            $usuari->eliminarPrestec($materialId);
        }

        return true;
    }

    // ----------------------
    // Usuaris
    // ----------------------
    public function afegirUsuari(Usuari $usuari): void {
        $this->usuaris[$usuari->__get('nom')] = $usuari;
    }

    public function cercarUsuari(string $nom): ?Usuari {
        return $this->usuaris[$nom] ?? null;
    }

    // ----------------------
    // Mètodes dinàmics
    // ----------------------
    public function __call($name, $arguments) {
        if (preg_match('/^get(Llibres|Revistes|DVDs)$/', $name, $matches)) {
            $tipus = rtrim($matches[1], 's'); // Llibres -> Llibre
            return $this->llistarPerTipus($tipus);
        }
        throw new BadMethodCallException("Mètode $name no existeix.");
    }

    // ----------------------
    // Estadístiques
    // ----------------------
    public function obtenirEstadistiques(): array {
        $total = count($this->materials);
        $disponibles = count($this->llistarDisponibles());
        $prestats = count($this->llistarPrestat());
        $perTipus = [
            'Llibre' => count($this->llistarPerTipus('Llibre')),
            'Revista' => count($this->llistarPerTipus('Revista')),
            'DVD' => count($this->llistarPerTipus('DVD'))
        ];
        return compact('total','disponibles','prestats','perTipus');
    }

    // ----------------------
    // Getters
    // ----------------------
    public function getMaterials(): array { return $this->materials; }
    public function getUsuaris(): array { return $this->usuaris; }
    public function getNom(): string { return $this->nom; }
}
?>