<?php

$busqueda = '';
$error = '';

if (array_key_exists('q', $_GET)) {
    if (!is_string($_GET['q'])) {
        $error = 'Entrada no válida. Introduce un texto.';
    } else {
        $busqueda = trim($_GET['q']);
    }
}

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Buscar libros</title>
</head>
<body>
    <form action="libros.php" method="get">
        <label for="buscar">Buscar libro:</label>
        <input type="text" name="q" id="buscar" value="<?= e($busqueda) ?>">
        <button type="submit">Buscar</button>
    </form>
    
    <?php if ($error !== ''): ?>
        <p><?= e($error) ?></p>
    <?php else: ?>
        <p>Búsqueda: <?= e($busqueda) ?></p>
    <?php endif; ?>
</body>
</html>