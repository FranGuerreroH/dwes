<?php

$esPost = ($_SERVER['REQUEST_METHOD'] ?? '') === 'POST';
$titulo = '';
$paginasTexto = '';
$paginas = null;
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

    $entradaPaginas = $_POST['paginas'] ?? '';
    if (!is_string($entradaPaginas)) {
        $errores['paginas'] = 'Las páginas deben recibirse como una cadena.';
    } else {
        $paginasTexto = $entradaPaginas;
        $resultadoPaginas = filter_var($entradaPaginas, FILTER_VALIDATE_INT);
        if ($resultadoPaginas === false) {
            $errores['paginas'] = 'Introduce un número entero.';
        } elseif ($resultadoPaginas < 1 || $resultadoPaginas > 3000) {
            $errores['paginas'] = 'El número debe estar entre 1 y 3000.';
        } else {
            $paginas = $resultadoPaginas;
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
    <title>Formulario de libro</title>
</head>
<body>
    <?php if ($esPost && $errores === []): ?>
        <p>Libro guardado: <?= e($titulo) ?> (<?= $paginas ?> páginas).</p>
    <?php else: ?>
        <form method="post" action="">
            <label for="titulo">Título</label>
            <input id="titulo" name="titulo" type="text" value="<?= e($titulo) ?>">
            <?php if (isset($errores['titulo'])): ?>
                <p><?= e($errores['titulo']) ?></p>
            <?php endif; ?>

            <label for="paginas">Páginas</label>
            <input id="paginas" name="paginas" type="number" value="<?= e($paginasTexto) ?>">
            <?php if (isset($errores['paginas'])): ?>
                <p><?= e($errores['paginas']) ?></p>
            <?php endif; ?>

            <button type="submit">Guardar</button>
        </form>
    <?php endif; ?>
</body>
</html>
