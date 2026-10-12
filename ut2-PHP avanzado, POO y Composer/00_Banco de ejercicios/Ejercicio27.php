<?php

$libros = [
    ['id' => 1, 'titulo' => 'Dune', 'paginas' => 412],
    ['id' => 2, 'titulo' => 'It', 'paginas' => 1504],
];

$busquedaInput = '  IT ';
$busqueda = mb_strtolower(trim($busquedaInput), 'UTF-8');

$visibles = array_filter(
    $libros,
    fn (array $l): bool => str_contains(
        mb_strtolower($l['titulo'], 'UTF-8'),
        $busqueda
    )
);

usort($libros, fn (array $a, array $b): int => $a['paginas'] <=> $b['paginas']);

$titulos = array_column($libros, 'titulo');
$etiquetas = array_map(fn (string $t): string => "Libro: $t", $titulos);

$libroEncontrado = array_find($libros, fn(array $l) => $l['id'] === 2);

print_r($visibles);
print_r($libros);
print_r($titulos);
print_r($etiquetas);
print_r($libroEncontrado);

?>