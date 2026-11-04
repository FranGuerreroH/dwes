<?php

$esPost = ($_SERVER['REQUEST_METHOD'] ?? '') === 'POST';
$generos = ['ciencia', 'fantasia', 'terror'];
$genero = '';
$destacado = false;
$observaciones = '';
$errores = [];

if ($esPost) {
    $entradaGenero = $_POST['genero'] ?? '';
    if (!is_string($entradaGenero) || !in_array($entradaGenero, $generos, true)) {
        $errores['genero'] = 'Selecciona un género válido.';
    } else {
        $genero = $entradaGenero;
    }

    if (array_key_exists('destacado', $_POST)) {
        if ($_POST['destacado'] === '1') {
            $destacado = true;
        } else {
            $errores['destacado'] = 'El valor de destacado no es válido.';
        }
    }

    $entradaObservaciones = $_POST['observaciones'] ?? '';
    if (!is_string($entradaObservaciones)) {
        $errores['observaciones'] = 'Las observaciones deben ser un texto.';
    } else {
        $observaciones = $entradaObservaciones;
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
    <title>Género y observaciones</title>
</head>
<body>
    <form method="post" action="">
        <label for="genero">Género</label>
        <select id="genero" name="genero">
            <option value="">Selecciona un género</option>
            <?php foreach ($generos as $opcion): ?>
                <option value="<?= e($opcion) ?>"<?= $genero === $opcion ? ' selected' : '' ?>><?= e($opcion) ?></option>
            <?php endforeach; ?>
        </select>
        <?php if (isset($errores['genero'])): ?>
            <p><?= e($errores['genero']) ?></p>
        <?php endif; ?>

        <label for="destacado">Destacado</label>
        <input id="destacado" name="destacado" type="checkbox" value="1"<?= $destacado ? ' checked' : '' ?>>
        <?php if (isset($errores['destacado'])): ?>
            <p><?= e($errores['destacado']) ?></p>
        <?php endif; ?>

        <label for="observaciones">Observaciones</label>
        <textarea id="observaciones" name="observaciones"><?= e($observaciones) ?></textarea>
        <?php if (isset($errores['observaciones'])): ?>
            <p><?= e($errores['observaciones']) ?></p>
        <?php endif; ?>

        <button type="submit">Enviar</button>
    </form>
</body>
</html>
