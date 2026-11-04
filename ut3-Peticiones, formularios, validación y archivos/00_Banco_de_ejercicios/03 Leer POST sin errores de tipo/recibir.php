<?php

$esPost = ($_SERVER['REQUEST_METHOD'] ?? '') === 'POST';
$titulo = '';
$errores = [];

if ($esPost) {
    $entrada = $_POST['titulo'] ?? '';
    if (!is_string($entrada)) {
        $errores['titulo'] = 'El título debe ser una cadena.';
    } else {
        $titulo = trim($entrada);
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
    <title>Recibir título</title>
</head>
<body>
    <form method="post" action="recibir.php">
        <label for="titulo">Título</label>
        <input id="titulo" name="titulo" type="text" value="<?= e($titulo) ?>">
        <?php if (isset($errores['titulo'])): ?>
            <p><?= e($errores['titulo']) ?></p>
        <?php endif; ?>
        <button type="submit">Enviar</button>
    </form>
</body>
</html>