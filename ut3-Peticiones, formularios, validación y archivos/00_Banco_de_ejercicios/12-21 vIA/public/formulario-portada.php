<?php

declare(strict_types=1);

const MAX_PORTADA_BYTES = 2 * 1024 * 1024;

$errores = [
    'campo' => [],
    'portada' => [],
    'general' => [],
];
$valores = [
    'titulo' => '',
    'paginas' => '',
];
$portadaActual = null;

$directorioPortadas = dirname(__DIR__) . '/storage/portadas';
if (is_dir($directorioPortadas)) {
    $ficheros = glob($directorioPortadas . '/*');
    if (is_array($ficheros) && $ficheros !== []) {
        $portadaActual = basename((string) $ficheros[0]);
    }
}

function validacionArchivo(?array $archivo, string $directorioPortadas): array
{
    if ($archivo === null) {
        return ['ok' => true, 'archivo' => null];
    }

    $estructuraValida = is_array($archivo)
        && isset($archivo['name'], $archivo['type'], $archivo['tmp_name'], $archivo['error'], $archivo['size'])
        && is_string($archivo['name'])
        && is_string($archivo['type'])
        && is_string($archivo['tmp_name'])
        && is_int($archivo['error'])
        && is_int($archivo['size']);

    if (!$estructuraValida) {
        return ['ok' => false, 'errores' => ['portada' => 'Entrada no válida.']];
    }

    if ($archivo['error'] === UPLOAD_ERR_NO_FILE) {
        return ['ok' => true, 'archivo' => null];
    }

    if ($archivo['error'] !== UPLOAD_ERR_OK) {
        $mensaje = 'No se pudo recibir la portada.';
        switch ($archivo['error']) {
            case UPLOAD_ERR_INI_SIZE:
                $mensaje = 'La portada excede el tamaño máximo permitido.';
                break;
            case UPLOAD_ERR_PARTIAL:
                $mensaje = 'La portada se subió parcialmente.';
                break;
        }

        return ['ok' => false, 'errores' => ['portada' => $mensaje]];
    }

    if ($archivo['size'] <= 0 || $archivo['size'] > MAX_PORTADA_BYTES) {
        return ['ok' => false, 'errores' => ['portada' => 'La portada debe tener entre 1 byte y 2 MiB.']];
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo !== false ? $finfo->file($archivo['tmp_name']) : false;
    $mapa = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
    ];

    if ($mime === false || !isset($mapa[$mime])) {
        return ['ok' => false, 'errores' => ['portada' => 'El formato de la portada no está permitido.']];
    }

    try {
        $nombre = bin2hex(random_bytes(16)) . '.' . $mapa[$mime];
        $destino = $directorioPortadas . '/' . $nombre;

        if (!is_dir($directorioPortadas) || !is_writable($directorioPortadas)) {
            return ['ok' => false, 'errores' => ['portada' => 'El directorio de almacenamiento no está disponible.']];
        }

        if (file_exists($destino)) {
            return ['ok' => false, 'errores' => ['portada' => 'Ya existe esa portada en el almacenamiento.']];
        }

        return ['ok' => true, 'archivo' => ['tmp_name' => $archivo['tmp_name'], 'destino' => $destino, 'nombre' => $nombre]];
    } catch (Random\RandomException) {
        return ['ok' => false, 'errores' => ['portada' => 'No se pudo preparar la nueva portada.']];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $valores['titulo'] = $_POST['titulo'] ?? '';
    $valores['paginas'] = $_POST['paginas'] ?? '';

    if (!is_string($valores['titulo'])) {
        $valores['titulo'] = '';
    }
    if (!is_string($valores['paginas'])) {
        $valores['paginas'] = '';
    }

    $valores['titulo'] = trim($valores['titulo']);
    $valores['paginas'] = trim($valores['paginas']);

    if ($valores['titulo'] === '') {
        $errores['campo'][] = 'El título es obligatorio.';
    }

    if ($valores['paginas'] === '' || !preg_match('/\A[1-9]\d*\z/', $valores['paginas']) || (int) $valores['paginas'] < 1 || (int) $valores['paginas'] > 999) {
        $errores['campo'][] = 'Las páginas deben ser un número entero entre 1 y 999.';
    }

    $resultadoArchivo = validacionArchivo($_FILES['portada'] ?? null, $directorioPortadas);
    if ($resultadoArchivo['ok'] === false && isset($resultadoArchivo['errores'])) {
        foreach ($resultadoArchivo['errores'] as $clave => $mensaje) {
            $errores[$clave][] = $mensaje;
        }
    }

    $nuevaPortada = $resultadoArchivo['archivo'] ?? null;

    if ($resultadoArchivo['ok'] === true && $nuevaPortada !== null && empty($errores['campo']) && empty($errores['portada']) && empty($errores['general'])) {
        $guardado = move_uploaded_file($nuevaPortada['tmp_name'], $nuevaPortada['destino']);
        if ($guardado) {
            $portadaActual = $nuevaPortada['nombre'];
        } else {
            $errores['general'][] = 'No se pudo mover la portada al almacenamiento.';
        }
    }

    if (empty($errores['campo']) && empty($errores['portada']) && empty($errores['general'])) {
        $mensajeExito = 'Datos guardados correctamente.';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de portada</title>
</head>
<body>
    <h1>Formulario de portada</h1>

    <?php if (isset($mensajeExito)): ?>
        <p><strong><?= htmlspecialchars($mensajeExito, ENT_QUOTES, 'UTF-8') ?></strong></p>
    <?php endif; ?>

    <?php foreach ($errores as $grupo => $mensajes): ?>
        <?php if ($mensajes !== []): ?>
            <div>
                <strong><?= htmlspecialchars($grupo, ENT_QUOTES, 'UTF-8') ?>:</strong>
                <ul>
                    <?php foreach ($mensajes as $mensaje): ?>
                        <li><?= htmlspecialchars((string) $mensaje, ENT_QUOTES, 'UTF-8') ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>

    <?php if ($portadaActual !== null): ?>
        <p>Portada actual: <code><?= htmlspecialchars($portadaActual, ENT_QUOTES, 'UTF-8') ?></code></p>
    <?php else: ?>
        <p>No hay portada actual asociada.</p>
    <?php endif; ?>

    <form action="formulario-portada.php" method="POST" enctype="multipart/form-data">
        <p>
            <label for="titulo">Título</label><br>
            <input id="titulo" name="titulo" type="text" value="<?= htmlspecialchars($valores['titulo'], ENT_QUOTES, 'UTF-8') ?>">
        </p>

        <p>
            <label for="paginas">Páginas</label><br>
            <input id="paginas" name="paginas" type="number" min="1" max="999" value="<?= htmlspecialchars($valores['paginas'], ENT_QUOTES, 'UTF-8') ?>">
        </p>

        <p>
            <label for="portada">Portada</label><br>
            <input id="portada" name="portada" type="file" accept="image/jpeg, image/png, image/webp">
        </p>

        <button type="submit">Enviar</button>
    </form>
</body>
</html>
