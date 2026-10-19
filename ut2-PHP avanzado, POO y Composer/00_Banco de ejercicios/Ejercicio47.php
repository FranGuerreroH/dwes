
<?php

abstract class RecursoBiblioteca
{
    public function __construct(
        private int $id,
        protected string $titulo
    ) {
        if ($id <= 0) {
            throw new InvalidArgumentException('El id debe ser positivo.');
        }

        if (trim($titulo) === '') {
            throw new InvalidArgumentException('El título no puede estar vacío.');
        }

        $this->titulo = trim($titulo);
    }

    public function id(): int
    {
        return $this->id;
    }

    public function titulo(): string
    {
        return $this->titulo;
    }

    abstract public function tipo(): string;

    final public function origen(): string
    {
        return 'Biblioteca';
    }
}

class Libro extends RecursoBiblioteca
{
    public function __construct(int $id, string $titulo, private int $paginas)
    {
        parent::__construct($id, $titulo);

        if ($paginas <= 0) {
            throw new InvalidArgumentException('Las páginas deben ser positivas.');
        }
    }

    public function tipo(): string
    {
        return 'libro';
    }

    public function ficha(): string
    {
        return $this->titulo . ' - ' . $this->paginas . ' páginas';
    }
}

class Revista extends RecursoBiblioteca
{
    public function __construct(int $id, string $titulo, private int $numero)
    {
        parent::__construct($id, $titulo);

        if ($numero <= 0) {
            throw new InvalidArgumentException('El número debe ser positivo.');
        }
    }

    public function tipo(): string
    {
        return 'revista';
    }

    public function ficha(): string
    {
        return $this->titulo . ' - número ' . $this->numero;
    }
}

$recursos = [
    new Libro(10, 'Dune', 412),
    new Revista(20, 'Ciencia', 7),
];

foreach ($recursos as $recurso) {
    echo $recurso->id() . ' - ' . $recurso->titulo() . ' - ' .
        $recurso->tipo() . ' - ' . $recurso->origen() . PHP_EOL;
    echo $recurso->ficha() . PHP_EOL;
}
