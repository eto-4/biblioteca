<?php 
require_once 'Material.php';
class DVD extends Material {

    // Propietats estatiques
    static protected int $TEMPS_MIN = 1;

    // Propietats privades
    protected int $duracio;

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
    }

    // Metodes Abstractes Implementats
    // ---------------------------------------------------------

    /**
     * Calcular Multa - Implementació del Metode Abstracte
     *  Retorna 1.00€ per dia de retard
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
     * */
    public function setDuracio(int $minuts): void {

        if ( $minuts < DVD::$TEMPS_MIN ) { throw new \InvalidArgumentException("La durada del DVD massa baix."); }
        $this->duracio = $minuts;
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
}
?> 
