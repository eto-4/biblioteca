<?php 
abstract class Material {

    // Propietats privades
    protected int $id;
    protected string $titol;
    protected string $autor;
    protected int $any_publicacio;
    protected bool $disponible = true;

    // Constructor
    public function __construct(
        int $id,
        string $titol,
        string $autor,
        int $any_publicacio,
        bool $disponible
    )
    // Cos del Constructor
    {

      // Assignar paràmetres a propietats.
      $this->id = $id;
      $this->titol = $titol;
      $this->autor = $autor;
      $this->any_publicacio = $any_publicacio;
      $this->disponible = $disponible;

    }

    // Metodes Abstractes
    // ---------------------------------------------------------

    /**
     * Calcular Multa - Metode Abstracte
     * Calcula la multa segons els dies de retard
     * */ 
    abstract public function calcularMulta(int $diesRetard): float;

    /**
     * Get Tipus - Metode Abstracte
     * Retorna el tipus de material ("Llibre", "Revista", "DVD")
    */
    abstract public function getTipus(): string;

    // Metodes - Funcionalitats
    // ---------------------------------------------------------

    /**
     * prestar(): bool
     * Marca el material com a no disponible si està disponible
     * */
    public function prestar(): bool {

        if (!$this->disponible) return false;

        // Marcar com a no disponible
        $this->disponible = false;
        return true;
    }

    /**
     * retornar(): void
     * Marca el material com a disponible
     * */
    public function retornar(): void {
        $this->disponible = true;
    }

    /**
     * __toString(): string
     * Retorna informació formatada del material
     * */
    public function __toString(): string {
        return "ID: {$this->id}" . PHP_EOL .
               "Títol: {$this->titol}" . PHP_EOL .
               "Autor: {$this->autor}" . PHP_EOL .
               "Any publicació: {$this->any_publicacio}" . PHP_EOL .
               "Disponible: " . ($this->disponible ? "Sí" : "No") . PHP_EOL .
               "Tipus: " . $this->getTipus() . PHP_EOL;
    }


    // Getters - ID, Titol, Autor, AnyPublicacio, Disponibilitat
    // ---------------------------------------------------------

    /**
     * Retornar l'ID del material
     * */
    public function getId(): int { return $this->id; }
    
    /**
     * Retornar el Titol del material
     * */
    public function getTitol(): string { return $this->titol; }

    /**
     * Retornar l'Autor del material
     * */
    public function getAutor(): string { return $this->autor; }

    /**
     * Retornar Any de Publicacio del material
     * */
    public function getAnyPublicacio(): int { return $this->any_publicacio; }

    /**
     * Retornar Disponibilitat del material
     * */
    public function isDisponible(): bool { return $this->disponible; }

}
?>