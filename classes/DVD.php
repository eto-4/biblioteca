<?php 
class DVD extends Material {
    
    // Usar Auditoria
    use Auditoria;

    // Propietats estatiques
    static protected int $TEMPS_MIN = 1;

    // Propietats protegida
    protected int $duracio;
    protected ?string $usuariReserva = null;

    // Constructor
    public function __construct(
      int $id,
      string $titol,
      string $autor,
      int $any_publicacio,
      bool $disponible,
      int $duracio
    )
    // Cos del Constructor
    {
      parent::__construct(
        $id,
        $titol,
        $autor,
        $any_publicacio,
        $disponible
      );

      $this->setDuracio($duracio);

      // Registrar estat inicial
      $this->registrarAccio(
        'creat',
        "ID: {$id}, Títol: {$titol}, Autor: {$autor}, Any: {$any_publicacio}, Disponible: " . ($disponible ? "Sí" : "No") . ", Duració: {$duracio}"
      );
    }

    // Metodes Abstractes Implementats
    // ---------------------------------------------------------

    /**
     * Calcular Multa - Implementació del Metode Abstracte
     * Retorna 1.00€ per dia de retard
     * @param int $diesRetard Quantitat de dies de retard després de la data limit.
     * 
     * */
    public function calcularMulta(int $diesRetard): float { return 1.00 * $diesRetard; }
    
    /**
     * Get Tipus - Implementació del Metode Abstracte
     * Retorna el tipus de material ("Llibre", "Revista", "DVD")
    */
    public function getTipus(): string { return 'DVD'; }

    // Getter - getNumeroEdicio
    // ---------------------------------------------------------

    /**
     * Retornar el número de minuts del DVD.
     * */
    public function getDuracio(): int { return $this->duracio; }

    // Setter - setDuracio
    // ---------------------------------------------------------

    /**
     * Inserta el número de minuts del DVD.
     * @param int $minuts quantita de minuts que es registraràn sobre el DVD.
     * */
    public function setDuracio(int $minuts): void {

        if ( $minuts < DVD::$TEMPS_MIN ) { throw new \InvalidArgumentException("La durada del DVD massa baix."); }
        $this->duracio = $minuts;
        $this->registrarAccio("NovaDurada", "Durada: {$minuts}min");
    }

    /**
     * Duracio Formatada - Ha de retornar format "2h 30min"
     * */
    public function getDuracioFormatada(): string {
        $totalMinuts = $this->duracio;
        $hores = intdiv($totalMinuts, 60);
        $minuts = $totalMinuts % 60;

        return "{$hores}h {$minuts}min";
    }

    /**
     * __toString(): string
     * Retorna informació formatada del DVD.
     * */
    public function __toString(): string {
        $info = parent::__toString() . "Duració: {$this->duracio}" . PHP_EOL;
        return (PHP_SAPI === 'cli') ? $info : nl2br($info);
    }

    // Implementacions Interfaces > Reservable

    /**
     * Reserva el material per a un usuari.
     *
     * Intenta reservar el material per l'usuari indicat.
     * Retorna false si ja està reservat.
     *
     * @param string $nomUsuari Nom de l'usuari que vol reservar el material.
     * @return bool True si la reserva s'ha realitzat correctament, false si ja estava reservat.
     */
    public function reservar(string $nomUsuari): bool {
        if ($this->usuariReserva !== null) return false;
        $this->usuariReserva = $nomUsuari;
        $this->registrarAccio('reservat', "Usuari: $nomUsuari");
        return true;
    }

    /**
     * Cancel·la la reserva actual del material.
     *
     * Retorna false si no hi havia cap reserva activa.
     *
     * @return bool True si la reserva s'ha cancel·lat correctament, false si no hi havia reserva.
     */
    public function cancelarReserva(): bool {
        if ($this->usuariReserva === null) return false;
        $this->registrarAccio('reserva_cancel·lada', "Usuari: $this->usuariReserva");
        $this->usuariReserva = null;
        return true;
    }

    /**
     * Comprova si el material està actualment reservat.
     *
     * @return bool True si hi ha una reserva activa, false si no.
     */
    public function estaReservat(): bool {
        return $this->usuariReserva !== null;
    }

    /**
     * Obté el nom de l'usuari que ha reservat el material.
     *
     * @return string|null Nom de l'usuari que ha fet la reserva, o null si no hi ha reserva.
     */
    public function getUsuariReserva(): ?string {
        return $this->usuariReserva;
    }
}
?> 
