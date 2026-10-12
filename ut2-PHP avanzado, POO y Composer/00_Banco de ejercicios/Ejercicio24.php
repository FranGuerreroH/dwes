<?php

function normalizarId(int|string $id): int {
    return (int) $id;
}

function etiqueta(?string $titulo): string {
    return $titulo !== null ? "Título: $titulo" : "Sin título";
}

var_dump(normalizarId(42));
var_dump(normalizarId('100'));

var_dump(etiqueta('Dune'));
var_dump(etiqueta(null));

?>