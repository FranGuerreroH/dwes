
<?php

class Libro
{
    public function __construct(
        public int $id,
        public string $titulo,
        public int $paginas,
        public bool $disponible = true
    ) {
    }

    public function prestar(): void
    {
        $this->disponible = false;
    }

    public function devolver(): void
    {
        $this->disponible = true;
    }
}

$datos = [
    ['id' => 10, 'titulo' => 'Dune', 'paginas' => 412, 'disponible' => true],
    ['id' => 20, 'titulo' => 'Drácula', 'paginas' => 418, 'disponible' => false],
    ['id' => 30, 'titulo' => '1984', 'paginas' => 328, 'disponible' => true],
    ['id' => 40, 'titulo' => 'It', 'paginas' => 1504, 'disponible' => true],
];

$libros = array_map(
    fn(array $dato): Libro => new Libro(
        $dato['id'],
        $dato['titulo'],
        $dato['paginas'],
        $dato['disponible']
    ),
    $datos
);

$disponibles = array_filter(
    $libros,
    fn(Libro $libro): bool => $libro->disponible
);

$encontrado = array_find(
    $libros,
    fn(Libro $libro): bool => $libro->id === 10
);

if ($encontrado !== null) {
    $encontrado->prestar();
    echo 'Disponible del resultado: ' . ($encontrado->disponible ? 'true' : 'false') . PHP_EOL;
}

$dune = array_find(
    $libros,
    fn(Libro $libro): bool => $libro->titulo === 'Dune'
);

echo 'Disponible de Dune: ' . ($dune?->disponible ? 'true' : 'false') . PHP_EOL;
echo 'Disponible en la lista anterior: ' .
    (array_find($disponibles, fn(Libro $libro): bool => $libro->titulo === 'Dune') !== null ? 'Sí' : 'No') .
    PHP_EOL;

$disponiblesActualizados = array_filter(
    $libros,
    fn(Libro $libro): bool => $libro->disponible
);

echo 'Disponibles actualizados:' . PHP_EOL;

foreach ($disponiblesActualizados as $libro) {
    echo $libro->titulo . PHP_EOL;
}

$noEncontrado = array_find(
    $libros,
    fn(Libro $libro): bool => $libro->id === 99
);

echo $noEncontrado?->titulo ?? 'Libro no encontrado';
echo PHP_EOL;
