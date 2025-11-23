<?php
/**
 * Excepció quan un material no està disponible per a préstec
 */
class MaterialNoDisponibleException extends Exception {

    private int $materialId;

    public function __construct(int $materialId, string $message = "") {
        $this->materialId = $materialId;
        $msg = $message ?: "Material amb ID {$materialId} no disponible.";
        parent::__construct($msg);
    }

    public function getMaterialId(): int {
        return $this->materialId;
    }

    public function __toString(): string {
        return __CLASS__ . ": [ID: {$this->materialId}] {$this->getMessage()}";
    }
}
?>
