<?php

$datos = $_POST;
$tipoPaginas = array_key_exists('paginas', $datos) ? get_debug_type($datos['paginas']) : 'no recibido';

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Datos recibidos</title>
</head>
<body>
    <h1>Datos recibidos</h1>
    <pre><?= htmlspecialchars(print_r($datos, true), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></pre>
    <p>Tipo recibido para paginas: <?= htmlspecialchars($tipoPaginas, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></p>
</body>
</html>