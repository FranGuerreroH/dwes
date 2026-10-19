
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
        titulo: $dato['titulo'],
        id: $dato['id'],
        paginas: $dato['paginas'],
        disponible: $dato['disponible']
    ),
    $datos
);

foreach ($libros as $libro) {
    echo $libro->id . ' - ' . $libro->titulo . ' - ' . $libro->paginas . PHP_EOL;
}

echo 'Objetos creados: ' . count($libros) . PHP_EOL;
echo 'El array original contiene registros: ' .
    (is_array($datos[0]) ? 'Sí' : 'No') . PHP_EOL;
