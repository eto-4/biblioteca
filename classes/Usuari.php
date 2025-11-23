<?php
require_once 'Material.php';
require_once '../traits/Auditoria.php';

/**
 * Classe Usuari
 *
 * Representa un usuari de la biblioteca amb gestió de préstecs i registre d'accions.
 */
class Usuari {

    // Usar Auditoria
    use Auditoria;

    // Propietats privades amb typed properties
    private string $nom;
    private string $email;
    private array $materialsPrestat = [];
    private DateTime $dataRegistre;

    /**
     * Constructor de l'usuari
     *
     * Inicialitza nom, email i data de registre. Registra l'acció de creació.
     *
     * @param string $nom Nom de l'usuari
     * @param string $email Email de l'usuari (validat)
     * @throws InvalidArgumentException Si l'email no és vàlid
     */
    public function __construct(string $nom, string $email) {
        $this->nom = $nom;

        if (!$this->validarEmail($email)) {
            throw new \InvalidArgumentException("Email no vàlid: $email");
        }
        $this->email = $email;
        $this->dataRegistre = new \DateTime(); // data actual

        // Registrar acció de creació d'usuari
        $this->registrarAccio("usuari_creat", "Nom: $nom, Email: $email");
    }

    // Mètodes màgics
    // ---------------------------------------------------------

    /**
     * __get: Permet accedir a propietats privades
     *
     * @param string $propietat Nom de la propietat
     * @return mixed Valor de la propietat
     */
    public function __get(string $propietat): mixed {
        return $this->$propietat ?? null;
    }

    /**
     * __set: Permet modificar només email amb validació
     *
     * @param string $propietat Nom de la propietat
     * @param mixed $valor Valor a assignar
     * @throws InvalidArgumentException si es intenta assignar email no vàlid
     */
    public function __set(string $propietat, mixed $valor): void {
        if ($propietat === 'email') {
            if (!$this->validarEmail($valor)) {
                throw new \InvalidArgumentException("Email no vàlid: $valor");
            }
            $oldEmail = $this->email;
            $this->email = $valor;

            // Registrar canvi de email
            $this->registrarAccio("email_modificat", "De: $oldEmail, A: $valor");
        }
    }

    /**
     * __sleep: Defineix propietats a serialitzar
     *
     * @return array Llista de propietats serialitzables
     */
    public function __sleep(): array {
        return ['nom', 'email', 'materialsPrestat', 'dataRegistre'];
    }

    /**
     * __wakeup: Accions després de deserialitzar
     */
    public function __wakeup(): void {
        if (!$this->dataRegistre instanceof \DateTime) {
            $this->dataRegistre = new \DateTime($this->dataRegistre);
        }
    }

    /**
     * __toString: Representació en string de l'usuari
     *
     * @return string Informació resum de l'usuari
     */
    public function __toString(): string {
        return "Usuari: {$this->nom}, Email: {$this->email}, Materials prestats: " . count($this->materialsPrestat);
    }

    // Gestió de préstecs
    // ---------------------------------------------------------

    /**
     * Afegeix material a la llista de prestats
     *
     * @param Material $material Material que es presta
     */
    public function afegirPrestec(Material $material): void {
        $this->materialsPrestat[$material->getId()] = $material;

        // Registrar acció de préstec
        $this->registrarAccio("material_prestat", "Material ID: {$material->getId()}, Títol: {$material->getTitol()}");
    }

    /**
     * Elimina material de la llista de prestats per ID
     *
     * @param int $materialId ID del material a eliminar
     */
    public function eliminarPrestec(int $materialId): void {
        if (isset($this->materialsPrestat[$materialId])) {
            $titol = $this->materialsPrestat[$materialId]->getTitol();
            unset($this->materialsPrestat[$materialId]);

            // Registrar acció de retorn
            $this->registrarAccio("material_retornat", "Material ID: $materialId, Títol: $titol");
        }
    }

    /**
     * Retorna materials actualment prestats
     *
     * @return array Array de materials prestats
     */
    public function getMaterialsPrestat(): array {
        return $this->materialsPrestat;
    }

    /**
     * Compta materials prestats
     *
     * @return int Nombre de materials prestats
     */
    public function getNumeroMaterialsPrestat(): int {
        return count($this->materialsPrestat);
    }

    // Validació
    // ---------------------------------------------------------

    /**
     * Valida format de l'email
     *
     * @param string $email Email a validar
     * @return bool True si l'email és vàlid, False si no
     */
    private function validarEmail(string $email): bool {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
}
?>