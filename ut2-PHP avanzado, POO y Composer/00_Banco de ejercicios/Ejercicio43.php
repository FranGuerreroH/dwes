<?php

class Libro
{
    private int $id;
    private string $titulo;
    private int $paginas;
    private bool $disponible;

    public function __construct(int $id, string $titulo, int $paginas)
    {
        if ($id <= 0) {
            throw new InvalidArgumentException('El id debe ser positivo.');
        }

        if (trim($titulo) === '') {
            throw new InvalidArgumentException('El título no puede estar vacío.');
        }

        if ($paginas <= 0) {
            throw new InvalidArgumentException('Las páginas deben ser positivas.');
        }

        $this->id = $id;
        $this->titulo = trim($titulo);
        $this->paginas = $paginas;
        $this->disponible = true;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function titulo(): string
    {
        return $this->titulo;
    }

    public function paginas(): int
    {
        return $this->paginas;
    }

    public function estaDisponible(): bool
    {
        return $this->disponible;
    }

    public function prestar(): void
    {
        if (!$this->disponible) {
            throw new LogicException('El libro ya está prestado.');
        }

        $this->disponible = false;
    }

    public function devolver(): void
    {
        $this->disponible = true;
    }
}

$dune = new Libro(10, 'Dune', 412);
$solaris = new Libro(20, 'Solaris', 216);

foreach ([$dune, $solaris] as $libro) {
    echo $libro->id() . ' - ' . $libro->titulo() . ' - ' .
        $libro->paginas() . ' páginas' . PHP_EOL;
}

$dune->prestar();

echo 'Dune: ' . ($dune->estaDisponible() ? 'Disponible' : 'Prestado') . PHP_EOL;
echo 'Solaris: ' . ($solaris->estaDisponible() ? 'Disponible' : 'Prestado') . PHP_EOL;

$dune->devolver();

echo 'Dune: ' . ($dune->estaDisponible() ? 'Disponible' : 'Prestado') . PHP_EOL;
echo 'Solaris: ' . ($solaris->estaDisponible() ? 'Disponible' : 'Prestado') . PHP_EOL;

$dune->prestar();

try {
    $dune->prestar();
} catch (LogicException $e) {
    echo $e->getMessage() . PHP_EOL;
}

echo 'Dune: ' . ($dune->estaDisponible() ? 'Disponible' : 'Prestado') . PHP_EOL;

try {
    new Libro(30, 'Libro inválido', 0);
} catch (InvalidArgumentException $e) {
    echo 'Construcción rechazada: ' . $e->getMessage() . PHP_EOL;
}