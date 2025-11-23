<?php
require_once 'Material.php';
require_once '../interfaces/Reservable.php';
require_once '../traits/Auditoria.php';
class Llibre extends Material implements Reservable {
    
    // Usar Auditoria
    use Auditoria;

    // Propietats estatiques
    static protected int $PAGINES_MIN = 1;
    // Propietats protegida
    protected int $numPag;
    protected ?string $usuariReserva = null;

    // Constructor
    public function __construct(
      int $id,
      string $titol,
      string $autor,
      int $any_publicacio,
      bool $disponible,
      int $numPag
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

      $this->setNumeroPagines($numPag);

      // Registrar estat inicial
      $this->registrarAccio(
        'creat',
        "ID: {$id}, Títol: {$titol}, Autor: {$autor}, Any: {$any_publicacio}, Disponible: " . ($disponible ? "Sí" : "No") . ", Pàgines: {$numPag}"
      );
    }

    // Metodes Abstractes Implementats
    // ---------------------------------------------------------

    /**
     * Calcular Multa - Implementació del Metode Abstracte
     * Retorna 0.50€ per dia de retard
     * @param int $diesRetard Quantitat de dies de retard després de la data limit.
     * */
    public function calcularMulta(int $diesRetard): float { return 0.50 * $diesRetard; }

    /**
     * Get Tipus - Implementació del Metode Abstracte
     * Retorna el tipus de material ("Llibre", "Revista", "DVD")
    */
    public function getTipus(): string { return 'Llibre'; }

    // Getter - getNumeroPagines
    // ---------------------------------------------------------

    /**
     * Retornar el número de pàgines d'un llibre
     * */
    public function getNumeroPagines(): int { return $this->numPag; }

    // Setter - setNumeroPagines
    // ---------------------------------------------------------

    /**
     * Inserta pàgines al llibre
     * @param int $pagines Número de pàgines que s'introduïrán al Llibre.
     * */
    public function setNumeroPagines(int $pagines): void {

        if ( $pagines < Llibre::$PAGINES_MIN ) { throw new \InvalidArgumentException("Número de pàgines massa baix."); }
        $this->numPag = $pagines;
        $this->registrarAccio("PàginesCount", "TotalPàgines: {$pagines}pag.");
    }

    /**
     * __toString(): string
     * Retorna informació formatada del Llibre
     * */
    public function __toString(): string {
        $info = parent::__toString() . "Págines: {$this->numPag}" . PHP_EOL;
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