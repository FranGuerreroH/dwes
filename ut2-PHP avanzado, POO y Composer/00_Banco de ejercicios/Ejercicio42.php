
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

function seleccionarDesdeEntrada(array $libros, mixed $entrada): array
{
    if (!is_string($entrada)) {
        echo 'Entrada no válida' . PHP_EOL;
        return [];
    }

    $maximo = filter_var($entrada, FILTER_VALIDATE_INT);

    if ($maximo === false || $maximo < 1) {
        echo 'Entrada no válida' . PHP_EOL;
        return [];
    }

    $seleccionados = array_filter(
        $libros,
        fn(Libro $libro): bool =>
            $libro->disponible && $libro->paginas <= $maximo
    );

    if ($seleccionados === []) {
        echo 'Sin coincidencias' . PHP_EOL;
        return [];
    }

    $titulos = array_map(
        fn(Libro $libro): string => $libro->titulo,
        $seleccionados
    );

    echo 'Títulos: ' . implode(', ', $titulos) . PHP_EOL;

    $masDe400 = array_any(
        $seleccionados,
        fn(Libro $libro): bool => $libro->paginas > 400
    );

    $paginasPositivas = array_all(
        $seleccionados,
        fn(Libro $libro): bool => $libro->paginas > 0
    );

    echo 'Algún libro supera las 400 páginas: ' .
        ($masDe400 ? 'Sí' : 'No') . PHP_EOL;

    echo 'Todos tienen páginas positivas: ' .
        ($paginasPositivas ? 'Sí' : 'No') . PHP_EOL;

    return array_values($seleccionados);
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

$entradas = ['500', '0', 'abc', ['500'], '100'];

foreach ($entradas as $entrada) {
    echo 'Entrada: ' . var_export($entrada, true) . PHP_EOL;
    seleccionarDesdeEntrada($libros, $entrada);
    echo PHP_EOL;
}
