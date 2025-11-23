<?php
/**
 * Excepció quan un material no està disponible per a préstec
 */
class MaterialNoDisponibleException extends Exception {

    private int $materialId;

    /**
     * Constructor
     *
     * @param int $materialId ID del material que no està disponible
     * @param string $message Missatge opcional
     */
    public function __construct(int $materialId, string $message = "") {
        $this->materialId = $materialId;
        $msg = $message ?: "Material amb ID {$materialId} no disponible.";
        parent::__construct($msg);
    }

    /**
     * Retorna l'ID del material
     */
    public function getMaterialId(): int {
        return $this->materialId;
    }

    /**
     * Representació en string
     */
    public function __toString(): string {
        return __CLASS__ . ": [ID: {$this->materialId}] {$this->getMessage()}";
    }
}
?>