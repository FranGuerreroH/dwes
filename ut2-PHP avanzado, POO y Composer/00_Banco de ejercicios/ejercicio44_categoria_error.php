
<?php

class Autor
{
    public function __construct(
        public readonly string $nombre,
        public readonly string $codigo
    ) {
    }
}

class Categoria
{
    private string $nombre;

    public function __construct(string $nombre)
    {
        $this->renombrar($nombre);
    }

    public function nombre(): string
    {
        return $this->nombre;
    }

    public function renombrar(string $nombre): void
    {
        $nombre = trim($nombre);

        if ($nombre === '') {
            throw new InvalidArgumentException('El nombre no puede estar vacío.');
        }

        $this->nombre = $nombre;
    }
}

class Libro
{
    private string $titulo;

    public function __construct(
        string $titulo,
        public readonly Autor $autor,
        public readonly Categoria $categoria
    ) {
        $titulo = trim($titulo);

        if ($titulo === '') {
            throw new InvalidArgumentException('El título no puede estar vacío.');
        }

        $this->titulo = $titulo;
    }

    public function ficha(): string
    {
        return $this->titulo . ' | ' . $this->autor->nombre . ' | ' .
            $this->categoria->nombre();
    }
}

$autor = new Autor('Frank Herbert', 'AUT-01');
$categoria = new Categoria('Ciencia ficción');

$dune = new Libro('Dune', $autor, $categoria);
$mesias = new Libro('El mesías de Dune', $autor, $categoria);

echo $dune->ficha() . PHP_EOL;
echo $mesias->ficha() . PHP_EOL;

$categoria->renombrar('Narrativa');

echo $dune->ficha() . PHP_EOL;
echo $mesias->ficha() . PHP_EOL;
