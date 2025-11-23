<?php
/**
 * Classe Prestec
 *
 * Representa un préstec d'un material a un usuari amb gestió de dates, càlcul de retard i multes.
 */
class Prestec {

    // Usar Auditoria
    use Auditoria;

    // Propietats privades
    private Material $material;
    private Usuari $usuari;
    private DateTime $dataPrestec;
    private ?DateTime $dataRetorn = null;
    private int $diesLimitPrestec;

    /**
     * Constructor del préstec
     *
     * Inicialitza el préstec amb material, usuari i dies de límit (default 14).
     * Registra l'acció de creació del préstec.
     *
     * @param Material $material Material que es presta
     * @param Usuari $usuari Usuari que rep el material
     * @param int $diesLimit Dies de límit del préstec (per defecte 14)
     * @throws MaterialNoDisponibleException Si el material no està disponible
     */
    public function __construct(Material $material, Usuari $usuari, int $diesLimit = 14) {
        if (!$material->estaDisponible()) {
            throw new MaterialNoDisponibleException($material->getId(), "Material no disponible per préstec.");
        }

        $this->material = $material;
        $this->usuari = $usuari;
        $this->dataPrestec = new DateTime();
        $this->diesLimitPrestec = $diesLimit;

        // Registrar acció de nou préstec
        $this->registrarAccio(
            "prestec_creat",
            "Material ID: {$material->getId()}, Títol: {$material->getTitol()}, Usuari: {$usuari->nom}, Dies límit: $diesLimit"
        );

        // Afegir material a l'usuari
        $usuari->afegirPrestec($material);
    }

    // Gestió del préstec
    // ---------------------------------------------------------

    /**
     * Retorna el material
     *
     * Estableix la data de retorn a ara i registra l'acció.
     */
    public function retornar(): void {
        if ($this->dataRetorn === null) {
            $this->dataRetorn = new DateTime();

            // Registrar acció de retorn
            $this->registrarAccio(
                "prestec_retornat",
                "Material ID: {$this->material->getId()}, Usuari: {$this->usuari->nom}"
            );

            // Treure-lo de l'usuari
            $this->usuari->eliminarPrestec($this->material->getId());
        }
    }

    /**
     * Calcula dies de retard
     *
     * @return int Nombre de dies de retard (0 si no hi ha)
     */
    public function calcularDiesRetard(): int {
        $ara = $this->dataRetorn ?? new DateTime();
        $diesTranscorreguts = (int)$this->dataPrestec->diff($ara)->format('%a');
        $retard = $diesTranscorreguts - $this->diesLimitPrestec;
        return max(0, $retard);
    }

    /**
     * Calcula la multa del préstec
     *
     * @return float Multa calculada usant el mètode del material
     */
    public function calcularMulta(): float {
        $diesRetard = $this->calcularDiesRetard();
        $multa = $this->material->calcularMulta($diesRetard);

        // Registrar càlcul de multa
        if ($diesRetard > 0) {
            $this->registrarAccio(
                "multa_calculada",
                "Material ID: {$this->material->getId()}, Usuari: {$this->usuari->nom}, Dies retard: $diesRetard, Multa: $multa"
            );
        }

        return $multa;
    }

    /**
     * Comprova si el préstec ha vençut
     *
     * @return bool True si el préstec ha superat el límit
     */
    public function estaVençut(): bool {
        $diesPendents = $this->getDiesPendents();
        return $diesPendents < 0;
    }

    /**
     * Retorna dies pendents fins al venciment (negatiu si vençut)
     *
     * @return int Dies pendents
     */
    public function getDiesPendents(): int {
        $ara = new DateTime();
        $diesTranscorreguts = (int)$this->dataPrestec->diff($ara)->format('%a');
        return $this->diesLimitPrestec - $diesTranscorreguts;
    }

    // Getters
    // ---------------------------------------------------------

    /**
     * Obté el material del préstec
     *
     * @return Material
     */
    public function getMaterial(): Material {
        return $this->material;
    }

    /**
     * Obté l'usuari del préstec
     *
     * @return Usuari
     */
    public function getUsuari(): Usuari {
        return $this->usuari;
    }

    /**
     * Obté la data del préstec
     *
     * @return DateTime
     */
    public function getDataPrestec(): DateTime {
        return $this->dataPrestec;
    }

    /**
     * Obté la data de retorn (null si no retornat)
     *
     * @return ?DateTime
     */
    public function getDataRetorn(): ?DateTime {
        return $this->dataRetorn;
    }

    /**
     * Obté els dies de límit del préstec
     *
     * @return int
     */
    public function getDiesLimitPrestec(): int {
        return $this->diesLimitPrestec;
    }
}
?>