<?php

function mostrar(mixed $valor): string {
    if (is_bool($valor)) {
        return $valor ? 'true' : 'false';
    }
    return (string) $valor;
}

echo mostrar(true) . "\n";
echo mostrar(42) . "\n";
echo mostrar('Dune') . "\n";

?>