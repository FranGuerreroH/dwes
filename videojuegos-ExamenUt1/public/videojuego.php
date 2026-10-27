<?php
declare(strict_types=1);

require_once  __DIR__ . '/../src/datos.php';
require_once  __DIR__ . '/../src/funciones.php';

$juegoId = (int) $_GET['id'] ?? 0;
$videojuego = buscarPorId($videojuegos, $juegoId);


 if ($videojuego === null) {
    // Completa el tratamiento del caso en el que el videojuego no existe.
    ?>

    <!doctype html>
    <html lang="es">
    <head>
        <meta charset="utf-8">
        <title>Videojuego no encontrado</title>
    </head>
    <body>
    </body>
    </html>
    <?php
    exit;
}

// Prepara las fechas y los valores que necesita la ficha.
$fechaLanzamiento = new  DateTimeImmutable($_GET['fechaLanzamiento'])->format(d/m/Y) ;// De dónde saco la fecha??
$hoy = new DateTimeImmutable()->format(d/m/Y);
$diasTranscurridos = $fechaLanzamiento->diff(DateTimeInterface $hoy); //0? Habrá que calcular algo, no?
$finNovedad = null;
$estado = '';

// COMPLETAR los cálculos anteriores utilizando los datos del videojuego.
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Ficha del videojuego</title>
</head>
<body>
    <h1><?= htmlspecialchars($videojuego['titulo'] ?? '') ?></h1>

    <dl>
        <dt>Estudio</dt>
        <dd><?= htmlspecialchars($videojuego['estudio'] ?? '') ?></dd>

        <dt>Género</dt>
        <dd><?= htmlspecialchars($videojuego['genero'] ?? '') ?></dd>

        <dt>Plataforma</dt>
        <dd><?= htmlspecialchars($videojuego['plataforma'] ?? '') ?></dd>

        <dt>Precio</dt>
        <dd>
            <?php if ($videojuego !== null): ?>
                <?= number_format($videojuego['precio'], 2, ',', '.') ?> €
            <?php endif; ?>
        </dd>

        <dt>Puntuación</dt>
        <dd><?= $videojuego['puntuacion'] ?? '' ?></dd>

        <dt>Fecha de lanzamiento</dt>
        <dd>$fechaLanzamiento</dd>

        <dt>Días desde el lanzamiento</dt>
        <dd>$diasTranscurridos</dd>

        <dt>Fin del periodo de novedad</dt>
        <dd>$finNovedad</dd>

        <dt>Estado</dt>
        <dd>$estado</dd>
    </dl>

    <p><a href="index.php">Volver al catálogo</a></p>
</body>
</html>
