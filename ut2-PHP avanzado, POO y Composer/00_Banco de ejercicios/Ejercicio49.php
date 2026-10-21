
<?php

class LibroNoDisponibleException extends RuntimeException
{
}

class Libro
{
    private string $titulo;
    private bool $disponible = true;

    public function __construct(string $titulo)
    {
        $titulo = trim($titulo);

        if ($titulo === '') {
            throw new InvalidArgumentException('El título no puede estar vacío.');
        }

        $this->titulo = $titulo;
    }

    public function titulo(): string
    {
        return $this->titulo;
    }

    public function estaDisponible(): bool
    {
        return $this->disponible;
    }

    public function prestar(): void
    {
        if (!$this->disponible) {
            throw new LibroNoDisponibleException(
                'El libro ' . $this->titulo . ' no está disponible.'
            );
        }

        $this->disponible = false;
    }

    public function devolver(): void
    {
        $this->disponible = true;
    }
}

$dune = new Libro('Dune');

$dune->prestar();

try {
    $dune->prestar();
} catch (LibroNoDisponibleException $e) {
    echo $e->getMessage() . PHP_EOL;
}

echo 'Disponible: ' . ($dune->estaDisponible() ? 'Sí' : 'No') . PHP_EOL;

$dune->devolver();
$dune->prestar();

echo 'Préstamo realizado correctamente: ' . $dune->titulo() . PHP_EOL;

try {
    new Libro('   ');
} catch (InvalidArgumentException $e) {
    echo 'Construcción rechazada: ' . $e->getMessage() . PHP_EOL;
}
