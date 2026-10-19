<?php
// Ejercicio 10. array_any y array_all
// Con un array de páginas, comprueba con array_any si existe algún libro con más de 1000 páginas y
// con array_all si todos tienen un número de páginas mayor que 0.

$paginas = [412, 328, 1138, 256];

$hayMasDe1000 = array_any(
    $paginas,
    fn($paginas) => $paginas > 1000
);

$todosMayoresQue0 = array_all(
    $paginas,
    fn($paginas) => $paginas > 0
);

var_dump($hayMasDe1000);   
var_dump($todosMayoresQue0);


?>