<?php
/**
 * Excepció quan un usuari no es troba en el sistema
 */
class UsuariNoTrobatException extends Exception {

    private string $nomUsuari;

    public function __construct(string $nomUsuari, string $message = "") {
        $this->nomUsuari = $nomUsuari;
        $msg = $message ?: "Usuari '{$nomUsuari}' no trobat.";
        parent::__construct($msg);
    }

    public function getNomUsuari(): string {
        return $this->nomUsuari;
    }

    public function __toString(): string {
        return __CLASS__ . ": [Usuari: {$this->nomUsuari}] {$this->getMessage()}";
    }
}
?>
