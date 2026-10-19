<?php
// Ejercicio 3. Arrow functions
// Reescribe una closure sencilla como arrow function. Usa un $factor externo, aplica la función a un
// número y explica qué variable se captura automáticamente por valor. -->

$factorExterno = 2;

$doble = fn(int $n): int => $n * $factorExterno;
echo $doble(8);

// La variable $factorExterno se captura automaticamente por valor
?>