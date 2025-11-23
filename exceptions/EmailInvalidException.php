<?php
/**
 * Excepció quan un email no és vàlid
 */
class EmailInvalidException extends Exception {

    private string $email;

    public function __construct(string $email, string $message = "") {
        $this->email = $email;
        $msg = $message ?: "Email '{$email}' no vàlid.";
        parent::__construct($msg);
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function __toString(): string {
        return __CLASS__ . ": [Email: {$this->email}] {$this->getMessage()}";
    }
}
?>
