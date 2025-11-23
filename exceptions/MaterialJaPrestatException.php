<?php
/**
 * Excepció quan un material ja està prestat i no pot prestar-se de nou.
 *
 * Aquesta excepció s'ha de llençar quan un usuari intenta agafar en préstec
 * un material que ja està prestat.
 */
class MaterialJaPrestatException extends Exception {

    /**
     * @var int ID del material que ja està prestat
     */
    private int $materialId;

    /**
     * Constructor
     *
     * @param int $materialId ID del material ja prestat
     * @param string $message Missatge opcional. Si no es proporciona, es genera un missatge per defecte.
     */
    public function __construct(int $materialId, string $message = "") {
        $this->materialId = $materialId;
        $msg = $message ?: "El material amb ID {$materialId} ja està prestat.";
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