<?php
require_once 'Material.php';
require_once 'Usuari.php';
require_once '../exceptions/MaterialNoDisponibleException.php';
require_once '../exceptions/UsuariNoTrobatException.php';
require_once '../exceptions/MaterialJaPrestatException.php';

/**
 * Classe Prestec
 *
 * Representa un préstec d'un material a un usuari.
 */
class Prestec {

    // Propietats privades
    private Material $material;
    private Usuari $usuari;
    private DateTime $dataPrestec;
    private ?DateTime $dataRetorn = null;
    private int $diesLimitPrestec;

    /**
     * Constructor
     *
     * @param Material $material Material que es presta
     * @param Usuari $usuari Usuari que rep el material
     * @param int $diesLimit Dies de límit per defecte (14)
     * @throws MaterialNoDisponibleException si el material no està disponible
     */
    public function __construct(Material $material, Usuari $usuari, int $diesLimit = 14) {
        if (!$material->estaDisponible()) {
            throw new MaterialNoDisponibleException($material->getId(), "El material no està disponible.");
        }

        $this->material = $material;
        $this->usuari = $usuari;
        $this->diesLimitPrestec = $diesLimit;
        $this->dataPrestec = new DateTime();

        // Opcional: marcar el material com prestat
        if ($material instanceof Reservable) {
            $material->reservar($usuari->getNom());
        }
    }

    /**
     * Retorna el material
     */
    public function retornar(): void {
        $this->dataRetorn = new DateTime();
        if ($this->material instanceof Reservable && $this->material->estaReservat()) {
            $this->material->cancelarReserva();
        }
    }

    /**
     * Calcula dies de retard
     *
     * @return int Dies de retard (0 si no n'hi ha)
     */
    public function calcularDiesRetard(): int {
        $ara = $this->dataRetorn ?? new DateTime();
        $diff = $this->dataPrestec->diff($ara);
        $diesPassats = (int)$diff->format('%a');
        return max(0, $diesPassats - $this->diesLimitPrestec);
    }

    /**
     * Calcula la multa
     *
     * @return float Multa segons el material
     */
    public function calcularMulta(): float {
        $diesRetard = $this->calcularDiesRetard();
        return $this->material->calcularMulta($diesRetard);
    }

    /**
     * Comprova si el préstec ha vençut
     */
    public function estaVençut(): bool {
        $ara = $this->dataRetorn ?? new DateTime();
        $diff = $this->dataPrestec->diff($ara);
        $diesPassats = (int)$diff->format('%a');
        return $diesPassats > $this->diesLimitPrestec;
    }

    /**
     * Dies pendents abans del límit (negatiu si vençut)
     */
    public function getDiesPendents(): int {
        $ara = new DateTime();
        $diff = $this->dataPrestec->diff($ara);
        $diesPassats = (int)$diff->format('%a');
        return $this->diesLimitPrestec - $diesPassats;
    }

    // Getters
    public function getMaterial(): Material { return $this->material; }
    public function getUsuari(): Usuari { return $this->usuari; }
    public function getDataPrestec(): DateTime { return $this->dataPrestec; }
    public function getDataRetorn(): ?DateTime { return $this->dataRetorn; }
    public function getDiesLimitPrestec(): int { return $this->diesLimitPrestec; }
}
?>