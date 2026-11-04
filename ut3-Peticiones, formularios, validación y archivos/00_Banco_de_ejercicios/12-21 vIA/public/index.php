<?php

declare(strict_types=1);

const MAX_PORTADA_BYTES = 2 * 1024 * 1024;

$errores = [];
$esPost = $_SERVER['REQUEST_METHOD'] === 'POST';
$archivo = $_FILES['portada'] ?? null;
$tuplaDestino = null;

$titulo = $_POST['titulo'] ?? '';
if (!is_string($titulo)) {
    $titulo = '';
}
$titulo = trim($titulo);
if ($titulo === '') {
    $errores['titulo'] = 'El título es obligatorio.';
}

$estructuraValida = is_array($archivo)
    && isset($archivo['error'], $archivo['size'], $archivo['tmp_name'])
    && is_int($archivo['error'])
    && is_int($archivo['size'])
    && is_string($archivo['tmp_name']);

if ($archivo !== null && !$estructuraValida) {
    $errores['portada'] = 'Entrada no válida.';
    $archivo = null;
}

if ($archivo !== null) {
    if ($archivo['error'] === UPLOAD_ERR_NO_FILE) {
        $archivo = null;
    } elseif ($archivo['error'] !== UPLOAD_ERR_OK) {
        switch ($archivo['error']) {
            case UPLOAD_ERR_INI_SIZE:
                $errores['portada'] = 'El archivo supera el tamaño máximo permitido.';
                break;
            case UPLOAD_ERR_PARTIAL:
                $errores['portada'] = 'La subida del archivo se interrumpió.';
                break;
            default:
                $errores['portada'] = 'No se pudo recibir la portada.';
                break;
        }
    } else {
        if ($archivo['size'] <= 0 || $archivo['size'] > MAX_PORTADA_BYTES) {
            $errores['portada'] = 'La portada debe tener entre 1 byte y 2 MiB.';
        } else {
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo !== false ? $finfo->file($archivo['tmp_name']) : false;
            $permitidos = [
                'image/jpeg' => 'jpg',
                'image/png' => 'png',
                'image/webp' => 'webp',
            ];

            if ($mime === false || !isset($permitidos[$mime])) {
                $errores['portada'] = 'Formato no permitido.';
            } else {
                $extension = $permitidos[$mime];
                $directorio = dirname(__DIR__) . '/storage/portadas';

                try {
                    $nombre = bin2hex(random_bytes(16)) . '.' . $extension;
                    $destino = $directorio . '/' . $nombre;

                    if (!is_dir($directorio) || !is_writable($directorio)) {
                        $errores['portada'] = 'No se puede escribir en el almacenamiento.';
                    } elseif (file_exists($destino)) {
                        $errores['portada'] = 'El nombre generado ya existe; vuelve a intentarlo.';
                    } else {
                        $tuplaDestino = ['tmp_name' => $archivo['tmp_name'], 'destino' => $destino];
                    }
                } catch (Random\RandomException) {
                    $errores['portada'] = 'No se pudo preparar el nombre de la portada.';
                }
            }
        }
    }
}

if ($esPost && empty($errores) && $tuplaDestino !== null) {
    $guardado = move_uploaded_file($tuplaDestino['tmp_name'], $tuplaDestino['destino']);
    if (!$guardado) {
        $errores['portada'] = 'No se pudo guardar la portada en el servidor.';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Portada</title>
</head>
<body>
    <h1>Portada</h1>

    <?php if (!empty($errores)): ?>
        <ul>
            <?php foreach ($errores as $campo => $mensaje): ?>
                <li><strong><?= htmlspecialchars((string) $campo, ENT_QUOTES, 'UTF-8') ?>:</strong>
                    <?= htmlspecialchars((string) $mensaje, ENT_QUOTES, 'UTF-8') ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="index.php" method="POST" enctype="multipart/form-data">
        <p>
            <label for="titulo">Título</label><br>
            <input id="titulo" name="titulo" type="text" value="<?= htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8') ?>">
        </p>

        <p>
            <label for="portada">Portada</label><br>
            <input id="portada" name="portada" type="file" accept="image/jpeg, image/png, image/webp">
        </p>

        <button type="submit">Guardar</button>
    </form>

    <?php if ($esPost): ?>
        <h2>Resultado</h2>
        <?php if (empty($errores)): ?>
            <p>El formulario se ha validado correctamente.</p>
        <?php else: ?>
            <p>Se ha detectado al menos un error en la solicitud.</p>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>
