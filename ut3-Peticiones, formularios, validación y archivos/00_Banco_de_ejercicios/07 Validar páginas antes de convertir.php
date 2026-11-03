<?php
// 7. Validar páginas antes de convertir
$paginas = (int) ($_POST['paginas'] ?? '');
if ($paginas >= 1 && $paginas <= 3000) {
 echo 'Número aceptado';
}
// Detecta qué ocurre con "12abc" y corrige el orden usando is_string y FILTER_VALIDATE_INT.
// Comprueba el resultado con === false antes del rango.
// Ensaya "1", "3000", "0", "3001", "12abc", "12.5" y un array. Conserva el texto erróneo para el control;
// convierte a entero solo un resultado válido.
