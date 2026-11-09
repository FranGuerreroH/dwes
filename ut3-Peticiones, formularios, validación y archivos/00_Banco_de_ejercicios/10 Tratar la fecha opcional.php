<?php

$esPost = ($_SERVER['REQUEST_METHOD'] ?? '') === 'POST';
$fechaTexto = '';
$fechaAlta = null;
$error = '';

if ($esPost) {
    $entradaFecha = $_POST['fechaAlta'] ?? '';
    if (!is_string($entradaFecha)) {
        $error = 'La fecha debe recibirse como una cadena.';
    } else {
        $fechaTexto = trim($entradaFecha);
        if ($fechaTexto !== '') {
            try {
                $fechaCreada = DateTimeImmutable::createFromFormat('!Y-m-d', $fechaTexto);
            } catch (ValueError) {
                $fechaCreada = false;
            }

            if ($fechaCreada === false || $fechaCreada->format('Y-m-d') !== $fechaTexto) {
                $error = 'Introduce una fecha válida con formato Y-m-d.';
            } else {
                $fechaAlta = $fechaCreada;
            }
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
    <title>Fecha opcional</title>
</head>
<body>
    <form method="post" action="">
        <label for="fechaAlta">Fecha de alta</label>
        <input id="fechaAlta" name="fechaAlta" type="text" value="<?= e($fechaTexto) ?>">
        <?php if ($error !== ''): ?>
            <p><?= e($error) ?></p>
        <?php elseif ($esPost && $fechaAlta === null): ?>
            <p>No se indicó fecha; el valor es null.</p>
        <?php elseif ($fechaAlta instanceof DateTimeImmutable): ?>
            <p>Fecha válida: <?= e($fechaAlta->format('Y-m-d')) ?></p>
        <?php endif; ?>
        <button type="submit">Enviar</button>
    </form>
</body>
</html>
