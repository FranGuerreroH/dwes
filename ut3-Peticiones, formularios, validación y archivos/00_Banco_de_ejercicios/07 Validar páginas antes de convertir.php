<?php

$esPost = ($_SERVER['REQUEST_METHOD'] ?? '') === 'POST';
$paginasTexto = '';
$paginas = null;
$error = '';

if ($esPost) {
    $entrada = $_POST['paginas'] ?? '';
    if (!is_string($entrada)) {
        $error = 'Las páginas deben recibirse como una cadena.';
    } else {
        $paginasTexto = $entrada;
        $resultado = filter_var($entrada, FILTER_VALIDATE_INT);
        if ($resultado === false) {
            $error = 'Introduce un número entero.';
        } elseif ($resultado < 1 || $resultado > 3000) {
            $error = 'El número debe estar entre 1 y 3000.';
        } else {
            $paginas = $resultado;
        }
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
    <title>Validar páginas</title>
</head>
<body>
    <form method="post" action="">
        <label for="paginas">Páginas</label>
        <input id="paginas" name="paginas" type="text" value="<?= e($paginasTexto) ?>">
        <?php if ($error !== ''): ?>
            <p><?= e($error) ?></p>
        <?php elseif ($paginas !== null): ?>
            <p>Número aceptado: <?= $paginas ?></p>
        <?php endif; ?>
        <button type="submit">Enviar</button>
    </form>
</body>
</html>
