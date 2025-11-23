<?php
require_once 'Material.php'; 
require_once '../traits/Auditoria.php';
class Revista extends Material {
 
    // Usar Auditoria
    use Auditoria;

    // Propietats estatiques
    static protected int $NUM_MIN = 1;

    // Propietats protegida
    protected int $numEdicio;

    // Constructor
    public function __construct(
      int $id,
      string $titol,
      string $autor,
      int $any_publicacio,
      bool $disponible,
      int $numEdicio
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

      $this->setNumeroEdicio($numEdicio);

      // Registrar estat inicial
      $this->registrarAccio(
        'creat',
        "ID: {$id}, Títol: {$titol}, Autor: {$autor}, Any: {$any_publicacio}, Disponible: " . ($disponible ? "Sí" : "No") . ", Num.Edició: {$numEdicio}"
      );
    }

    
    // Metodes Abstractes Implementats
    // ---------------------------------------------------------

    /**
     * Calcular Multa - Implementació del Metode Abstracte
     * Retorna 0.25€ per dia de retard
     * @param int $diesRetard Quantitat de dies de retard després de la data limit.
     * */
    public function calcularMulta(int $diesRetard): float { return 0.25 * $diesRetard; }
    
    /**
     * Get Tipus - Implementació del Metode Abstracte
     * Retorna el tipus de material ("Llibre", "Revista", "DVD")
    */
    public function getTipus(): string { return 'Revista'; }

    // Getter - getNumeroEdicio
    // ---------------------------------------------------------

    /**
     * Retornar el número d'edició de la revista.
     * */
    public function getNumeroEdicio(): int { return $this->numEdicio; }

    // Setter - setNumeroEdicio
    // ---------------------------------------------------------

    /**
     * Inserta el número d'edició a la revista.
     * @param int $numero Número d'edició que s'introduïrán a la revista.
     * */
    public function setNumeroEdicio(int $numero): void {

        if ( $numero < Revista::$NUM_MIN ) { throw new \InvalidArgumentException("Número d'edició massa baix."); }
        $this->numEdicio = $numero;
        $this->registrarAccio("NovaEdició", "Edició: $numero");
    }

    /**
     * __toString(): string
     * Retorna informació formatada de la Revista.
     * */
    public function __toString(): string {
        $info = parent::__toString() . "Edició: {$this->numEdicio}" . PHP_EOL;
        return (PHP_SAPI === 'cli') ? $info : nl2br($info);
    }
}
?> 
