<?php
require_once 'Material.php';
class Llibre extends Material {

    // Propietats estatiques
    static protected int $PAGINES_MIN = 1;

    // Propietats privades
    protected int $numPag;

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

        $this->numPag = $numPag;
    }

    // Metodes Abstractes Implementats
    // ---------------------------------------------------------

    /**
     * Calcular Multa - Metode Abstracte Implementat
     *  Retorna 0.50€ per dia de retard
     * */
    public function calcularMulta(int $diesRetard): float { return 0.50 * $diesRetard; }

    /**
     * Get Tipus - Metode Abstracte Implementat
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
     * */
    public function setNumeroPagines(int $pagines): void {

        if ( $pagines < Llibre::$PAGINES_MIN ) { throw new \InvalidArgumentException("Número de pàgines massa baix."); }
        $this->numPag = $pagines;
    }

    /**
     * __toString(): string
     * Retorna informació formatada del Llibre
     * */
    public function __toString(): string {
        $info = parent::__toString() . "Págines: {$this->numPag}" . PHP_EOL;
        return (PHP_SAPI === 'cli') ? $info : nl2br($info);
    }
}
?>