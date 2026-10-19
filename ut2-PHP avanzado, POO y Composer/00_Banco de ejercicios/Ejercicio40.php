
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

usort(
    $libros,
    fn(Libro $a, Libro $b): int => $a->paginas <=> $b->paginas
);

$total = array_reduce(
    $libros,
    fn(int $acumulador, Libro $libro): int => $acumulador + $libro->paginas,
    0
);

foreach ($libros as $libro) {
    echo $libro->titulo . ' - ' . $libro->paginas . ' páginas' . PHP_EOL;
}

echo 'Total de páginas: ' . $total . PHP_EOL;

usort(
    $libros,
    fn(Libro $a, Libro $b): int => $b->paginas <=> $a->paginas
);

echo 'Orden descendente:' . PHP_EOL;

foreach ($libros as $libro) {
    echo $libro->titulo . ' - ' . $libro->paginas . ' páginas' . PHP_EOL;
}
