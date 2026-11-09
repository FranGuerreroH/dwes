<?php

$esPost = ($_SERVER['REQUEST_METHOD'] ?? '') === 'POST';
$titulo = '';
$autor = '';
$errores = [];

if ($esPost) {
    $entradaTitulo = $_POST['titulo'] ?? '';
    if (!is_string($entradaTitulo)) {
        $errores['titulo'] = 'El título debe ser una cadena.';
    } else {
        $titulo = trim($entradaTitulo);
        if ($titulo === '') {
            $errores['titulo'] = 'El título es obligatorio.';
        } elseif (mb_strlen($titulo, 'UTF-8') > 120) {
            $errores['titulo'] = 'El título no puede tener más de 120 caracteres.';
        }
    }

    $entradaAutor = $_POST['autor'] ?? '';
    if (!is_string($entradaAutor)) {
        $errores['autor'] = 'El autor debe ser una cadena.';
    } else {
        $autor = trim($entradaAutor);
        if ($autor === '') {
            $errores['autor'] = 'El autor es obligatorio.';
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
    <title>Validar título y autor</title>
</head>
<body>
    <form method="post" action="">
        <label for="titulo">Título</label>
        <input id="titulo" name="titulo" type="text" value="<?= e($titulo) ?>">
        <?php if (isset($errores['titulo'])): ?>
            <p><?= e($errores['titulo']) ?></p>
        <?php endif; ?>
        <label for="autor">Autor</label>
        <input id="autor" name="autor" type="text" value="<?= e($autor) ?>">
        <?php if (isset($errores['autor'])): ?>
            <p><?= e($errores['autor']) ?></p>
        <?php endif; ?>
        <button type="submit">Enviar</button>
    </form>
</body>
</html>
