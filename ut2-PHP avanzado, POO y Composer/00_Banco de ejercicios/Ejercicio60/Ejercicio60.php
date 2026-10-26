<?php

function titulosDisponiblesHasta(array $datos, int $maximo): array
{
    if ($maximo < 1) {
        throw new InvalidArgumentException('El máximo de páginas debe ser al menos 1.');
    }

    $disponibles = array_filter(
        $datos,
        static fn (array $libro): bool => $libro['disponible'] && $libro['paginas'] <= $maximo
    );

    return array_map(
        static fn (array $libro): string => $libro['titulo'],
        $disponibles
    );
}

class Libro
{
    public function __construct(
        private string $titulo,
        private int $paginas,
        private bool $disponible
    ) {
    }

    public function titulo(): string
    {
        return $this->titulo;
    }

    public function paginas(): int
    {
        return $this->paginas;
    }

    public function disponible(): bool
    {
        return $this->disponible;
    }
}

class CatalogoService
{
    /** @param Libro[] $libros */
    public function __construct(private array $libros)
    {
    }

    public function titulosDisponiblesHasta(int $maximo): array
    {
        if ($maximo < 1) {
            throw new InvalidArgumentException('El máximo de páginas debe ser al menos 1.');
        }

        $disponibles = array_filter(
            $this->libros,
            static fn (Libro $libro): bool => $libro->disponible() && $libro->paginas() <= $maximo
        );

        return array_map(
            static fn (Libro $libro): string => $libro->titulo(),
            $disponibles
        );
    }
}

$datos = [
    ['titulo' => 'Dune', 'paginas' => 412, 'disponible' => true],
    ['titulo' => 'Solaris', 'paginas' => 216, 'disponible' => false],
    ['titulo' => 'Drácula', 'paginas' => 418, 'disponible' => true],
    ['titulo' => 'El Hobbit', 'paginas' => 310, 'disponible' => true],
];

$libros = array_map(
    static fn (array $libro): Libro => new Libro(
        $libro['titulo'],
        $libro['paginas'],
        $libro['disponible']
    ),
    $datos
);
$catalogo = new CatalogoService($libros);
$maximos = [400, 500, 100];
$formatearTitulos = static function (array $titulos): string {
    $titulos = array_values($titulos);

    if ($titulos === []) {
        return '(lista vacía)';
    }

    if (count($titulos) === 1) {
        return $titulos[0];
    }

    $ultimo = array_pop($titulos);

    return implode(', ', $titulos) . ' y ' . $ultimo;
};

echo "Función:\n";
foreach ($maximos as $maximo) {
    $titulos = titulosDisponiblesHasta($datos, $maximo);
    echo $maximo . ': ' . $formatearTitulos($titulos) . PHP_EOL;
}

echo "Servicio:\n";
foreach ($maximos as $maximo) {
    $titulos = $catalogo->titulosDisponiblesHasta($maximo);
    echo $maximo . ': ' . $formatearTitulos($titulos) . PHP_EOL;
}

try {
    titulosDisponiblesHasta($datos, 0);
} catch (InvalidArgumentException $exception) {
    echo 'Rechazo de la función: ' . $exception->getMessage() . PHP_EOL;
}

try {
    $catalogo->titulosDisponiblesHasta(0);
} catch (InvalidArgumentException $exception) {
    echo 'Rechazo del servicio: ' . $exception->getMessage() . PHP_EOL;
}
