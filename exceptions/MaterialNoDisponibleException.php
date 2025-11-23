<?php
/**
 * Excepció quan un material no està disponible per a préstec
 * (per exemple, si està bloquejat o retirat temporalment)
 */
class MaterialNoDisponibleException extends Exception {

    /**
     * @var int ID del material no disponible
     */
    private int $materialId;

    /**
     * Constructor
     *
     * @param int $materialId ID del material no disponible
     * @param string $message Missatge opcional. Si no es proporciona, es genera un missatge per defecte.
     */
    public function __construct(int $materialId, string $message = "") {
        $this->materialId = $materialId;
        $msg = $message ?: "El material amb ID {$materialId} no està disponible per a préstec.";
        parent::__construct($msg);
    }

    /**
     * Retorna l'ID del material
     *
     * @return int
     */
    public function getMaterialId(): int {
        return $this->materialId;
    }

    /**
     * Representació en string de l'excepció
     *
     * @return string
     */
    public function __toString(): string {
        return __CLASS__ . ": [ID: {$this->materialId}] {$this->getMessage()}";
    }
}
?>