<?php
$directorio = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'storage'
    . DIRECTORY_SEPARATOR . 'carteles';
$rutas = glob($directorio . DIRECTORY_SEPARATOR . '*');
$carteles = [];
$mimesPermitidos = ['image/jpeg', 'image/png', 'image/webp'];

if ($rutas !== false) {
    $finfo = new finfo(FILEINFO_MIME_TYPE);

    foreach ($rutas as $ruta) {
        $nombre = basename($ruta);

        if (
            !preg_match('/\A[a-f0-9]{32}\.(jpg|png|webp)\z/', $nombre)
            || !is_file($ruta)
            || !is_readable($ruta)
        ) {
            continue;
        }

        $mime = $finfo->file($ruta);
        if ($mime !== false && in_array($mime, $mimesPermitidos, true)) {
            $carteles[] = $nombre;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galería de carteles</title>
</head>

<body>
    <h1>Galería de carteles</h1>

    <?php if ($rutas === false): ?>
        <p>No se pudo cargar la galería.</p>
    <?php elseif ($carteles === []): ?>
        <p>Todavía no hay carteles.</p>
    <?php else: ?>
        <?php foreach ($carteles as $nombre): ?>
            <?php $nombreEscapado = htmlspecialchars($nombre, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>
            <article>
                <img
                    src="<?= htmlspecialchars('imagen.php?nombre=' . rawurlencode($nombre), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>"
                    alt="Cartel <?= $nombreEscapado ?>">
                <p><?= $nombreEscapado ?></p>
                <a href="<?= htmlspecialchars('subir.php?anterior=' . rawurlencode($nombre), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">Sustituir</a>
            </article>
        <?php endforeach; ?>
    <?php endif; ?>

    <p><a href="subir.php">Subir cartel</a></p>
</body>

</html>

<!--ME HE QUEDADO EN EL PUNTO 6 -->