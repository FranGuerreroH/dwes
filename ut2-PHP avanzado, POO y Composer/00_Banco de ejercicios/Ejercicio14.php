<?php
$libros = [
    ['titulo' => 'Dune', 'paginas' => 412],
    ['titulo' => 'It', 'paginas' => 1504],
    ['titulo' => 'El Hobbit', 'paginas' => 310]
];

usort($libros, fn($a, $b) => $a['paginas'] <=> $b['paginas']);
print_r($libros);

usort($libros, fn($a, $b) => $b['paginas'] <=> $a['paginas']);
print_r($libros);
?>