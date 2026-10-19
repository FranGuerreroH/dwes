<?php

$texto = "Texto   con\t\tvarios    espacios\ny\tsaltos.";
$normalizado = preg_replace('/\s+/', ' ', $texto);

echo $normalizado . "\n";

?>