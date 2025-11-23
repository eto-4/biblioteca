<?php
/**
 * Trait Auditoria
 *
 * Proporciona funcionalitats per registrar accions i mantenir un historial d'activitats.
 * Totes les classes que heretin de Material han d'utilitzar aquest trait.
 * Exemple d'accions: "prestat", "retornat", "reservat", "reserva_cancel·lada".
 */
trait Auditoria {

    /** 
     * Historial d'accions.
     * Cada entrada és un array amb:
     * - timestamp: data i hora de l'acció
     * - accio: nom de l'acció
     * - detalls: informació addicional (opcional)
     */
    private array $historial = [];

    // Metodes - Funcionalitats
    // ---------------------------------------------------------

    /**
     * Afegeix una entrada a l'historial amb timestamp.
     *
     * @param string $accio Nom de l'acció (ex: "prestat", "retornat").
     * @param string $detalls Detalls addicionals de l'acció (opcional).
     * @return void
     */
    public function registrarAccio(string $accio, string $detalls = ''): void {
        $this->historial[] = [
            'timestamp' => date('Y-m-d H:i:s'),
            'accio' => $accio,
            'detalls' => $detalls
        ];
    }

    /**
     * Retorna tot l'historial d'accions.
     *
     * @return array Historial complet d'accions.
     */
    public function obtenirHistorial(): array {
        return $this->historial;
    }

    /**
     * Retorna l'última acció registrada, o null si no n'hi ha cap.
     *
     * @return array|null Última acció amb timestamp, accio i detalls, o null si l'historial està buit.
     */
    public function obtenirUltimaAccio(): ?array {
        return !empty($this->historial) ? end($this->historial) : null;
    }

    /**
     * Buida completament l'historial d'accions.
     *
     * @return void
     */
    public function netejarHistorial(): void {
        $this->historial = [];
    }
}
?>
