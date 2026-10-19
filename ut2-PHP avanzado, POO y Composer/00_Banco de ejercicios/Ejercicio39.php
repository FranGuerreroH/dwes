
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
        id: $dato['id'],
        titulo: $dato['titulo'],
        paginas: $dato['paginas'],
        disponible: $dato['disponible']
    ),
    $datos
);

$busqueda = mb_strtolower(trim(' DRÁ '), 'UTF-8');

$encontrados = array_filter(
    $libros,
    fn(Libro $libro): bool =>
        mb_strpos(mb_strtolower($libro->titulo, 'UTF-8'), $busqueda, 0, 'UTF-8') !== false
);

$etiquetas = array_map(
    fn(Libro $libro): string => $libro->titulo . ' - ' . $libro->paginas . ' páginas',
    $encontrados
);

foreach ($etiquetas as $etiqueta) {
    echo $etiqueta . PHP_EOL;
}

$busqueda = mb_strtolower(trim('xyz'), 'UTF-8');

$encontrados = array_filter(
    $libros,
    fn(Libro $libro): bool =>
        mb_strpos(mb_strtolower($libro->titulo, 'UTF-8'), $busqueda, 0, 'UTF-8') !== false
);

if ($encontrados === []) {
    echo 'Sin resultados' . PHP_EOL;
}

$captura = 'La arrow function utiliza la variable $busqueda del ámbito exterior mediante captura automática por valor.';
echo $captura . PHP_EOL;
