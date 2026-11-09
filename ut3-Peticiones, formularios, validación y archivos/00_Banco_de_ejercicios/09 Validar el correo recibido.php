<?php

$esPost = ($_SERVER['REQUEST_METHOD'] ?? '') === 'POST';
$resultadoOriginal = null;
$resultadoTrasModificarPost = null;
$resultadoNormalizado = null;
$emailNormalizado = '';
$errorNormalizado = '';

if ($esPost) {
    $emailRecibido = $_POST['email'] ?? null;
    $resultadoOriginal = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

    $_POST['email'] = 'lector@example.org';
    $resultadoTrasModificarPost = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

    if (is_string($emailRecibido)) {
        $emailNormalizado = trim($emailRecibido);
        $resultadoNormalizado = filter_var($emailNormalizado, FILTER_VALIDATE_EMAIL);
    } else {
        $errorNormalizado = 'El correo debe recibirse como una cadena.';
    }
}

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function mostrarResultado(mixed $resultado): string
{
    if ($resultado === null) {
        return 'El campo no ha llegado.';
    }
    if ($resultado === false) {
        return 'Correo no válido.';
    }
    return 'Correo válido: ' . $resultado;
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Validar correo</title>
</head>
<body>
    <form method="post" action="">
        <label for="email">Correo</label>
        <input id="email" name="email" type="text" value="<?= e($emailNormalizado) ?>">
        <button type="submit">Enviar</button>
    </form>
    <?php if ($esPost): ?>
        <p>filter_input: <?= e(mostrarResultado($resultadoOriginal)) ?></p>
        <p>filter_input después de cambiar $_POST: <?= e(mostrarResultado($resultadoTrasModificarPost)) ?></p>
        <?php if ($errorNormalizado !== ''): ?>
            <p><?= e($errorNormalizado) ?></p>
        <?php else: ?>
            <p>filter_var después de recortar: <?= e(mostrarResultado($resultadoNormalizado)) ?></p>
        <?php endif; ?>
        <p>filter_input consulta el dato original de la petición; modificar $_POST no cambia ese valor.</p>
    <?php endif; ?>
</body>
</html>
