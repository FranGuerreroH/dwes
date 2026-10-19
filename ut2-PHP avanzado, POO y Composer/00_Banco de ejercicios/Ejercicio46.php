
<?php

class Libro
{
    public function __construct(
        private int $id,
        private string $titulo
    ) {
    }

    public function id(): int
    {
        return $this->id;
    }

    public function titulo(): string
    {
        return $this->titulo;
    }
}

interface LibroRepository
{
    public function todos(): array;
}

class ArrayLibroRepository implements LibroRepository
{
    public function __construct(private array $libros)
    {
    }

    public function todos(): array
    {
        return $this->libros;
    }
}

class CatalogoDemostracionRepository implements LibroRepository
{
    public function todos(): array
    {
        return [
            new Libro(10, 'Dune'),
            new Libro(20, 'Solaris'),
        ];
    }
}

function mostrarCatalogo(LibroRepository $repositorio): void
{
    $libros = $repositorio->todos();

    if ($libros === []) {
        echo 'Catálogo vacío' . PHP_EOL;
    }

    foreach ($libros as $libro) {
        echo $libro->id() . ' - ' . $libro->titulo() . PHP_EOL;
    }

    echo 'Total de libros: ' . count($libros) . PHP_EOL;
}

mostrarCatalogo(new CatalogoDemostracionRepository());

mostrarCatalogo(
    new ArrayLibroRepository([
        new Libro(30, 'Drácula'),
        new Libro(40, 'El Hobbit'),
    ])
);

mostrarCatalogo(new ArrayLibroRepository([]));
