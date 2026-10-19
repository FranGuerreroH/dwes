<?php

function sumarPaginas(int ...$paginas): int {
    return array_sum($paginas);
}

$arrayPaginas = [412, 1504, 310];

$resultadoUnpacking = sumarPaginas(...$arrayPaginas);

$resultadoManual = sumarPaginas(412, 1504, 310);

var_dump($resultadoUnpacking);
var_dump($resultadoManual);
var_dump($resultadoUnpacking === $resultadoManual);

?>