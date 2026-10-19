<?php
$catalogo = [
    10 => 'Dune',
    20 => 'It',
    30 => 'El Hobbit'
];

uasort($catalogo, fn($a, $b) => $a <=> $b);
print_r($catalogo);
?>