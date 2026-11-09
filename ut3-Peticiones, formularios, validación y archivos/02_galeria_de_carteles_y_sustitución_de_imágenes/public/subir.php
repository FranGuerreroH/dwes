<?php
$mensaje = null;
$imagenGuardada = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!is_array($_FILES)) {
        $mensaje = 'La información del archivo recibido no es válida.';
    } elseif (!array_key_exists('imagen', $_FILES)) {
        $mensaje = 'Selecciona una imagen.';
    } else {
        $archivo = $_FILES['imagen'];

        if (
            !is_array($archivo)
            || !array_key_exists('error', $archivo)
            || !array_key_exists('size', $archivo)
            || !array_key_exists('tmp_name', $archivo)
            || !is_int($archivo['error'])
            || !is_int($archivo['size'])
            || !is_string($archivo['tmp_name'])
        ) {
            $mensaje = 'La información del archivo recibido no es válida.';
        } else {
            switch ($archivo['error']) {
                case UPLOAD_ERR_NO_FILE:
                    $mensaje = 'Selecciona una imagen.';
                    break;
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    $mensaje = 'La imagen supera el tamaño máximo permitido.';
                    break;
                case UPLOAD_ERR_PARTIAL:
                    $mensaje = 'La recepción de la imagen quedó incompleta.';
                    break;
                case UPLOAD_ERR_CANT_WRITE:
                    $mensaje = 'No se pudo escribir la imagen recibida.';
                    break;
                case UPLOAD_ERR_OK:
                    if ($archivo['size'] < 1 || $archivo['size'] > 2097152) {
                        $mensaje = 'La imagen debe ocupar entre 1 y 2 MiB.';
                        break;
                    }

                    if (!is_file($archivo['tmp_name']) || !is_readable($archivo['tmp_name'])) {
                        $mensaje = 'No se puede leer el archivo temporal recibido.';
                        break;
                    }

                    $finfo = new finfo(FILEINFO_MIME_TYPE);
                    $mime = $finfo->file($archivo['tmp_name']);
                    $extensiones = [
                        'image/jpeg' => 'jpg',
                        'image/png' => 'png',
                        'image/webp' => 'webp',
                    ];

                    if ($mime === false || !isset($extensiones[$mime])) {
                        $mensaje = 'La imagen no es válida.';
                        break;
                    }

                    $extension = $extensiones[$mime];

                    $directorio = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'storage'
                        . DIRECTORY_SEPARATOR . 'carteles';
                    if (!is_dir($directorio) || !is_writable($directorio)) {
                        $mensaje = 'No se pudo guardar la imagen.';
                        break;
                    }

                    try {
                        do {
                            $nombre = bin2hex(random_bytes(16)) . '.' . $extension;
                            $destino = $directorio . DIRECTORY_SEPARATOR . $nombre;
                            $reserva = @fopen($destino, 'x');
                        } while ($reserva === false && file_exists($destino));
                    } catch (Random\RandomException $e) {
                        $mensaje = 'No se pudo preparar el archivo.';
                        break;
                    }

                    if ($reserva === false) {
                        $mensaje = 'No se pudo preparar el archivo.';
                        break;
                    }

                    fclose($reserva);

                    if (!move_uploaded_file($archivo['tmp_name'], $destino)) {
                        @unlink($destino);
                        $mensaje = 'No se pudo guardar la imagen.';
                        break;
                    }

                    $imagenGuardada = $nombre;
                    $mensaje = 'La imagen se ha guardado correctamente.';
                    break;
                default:
                    $mensaje = 'Se produjo un error al recibir la imagen.';
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir</title>
</head>

<body>
    <?php if ($mensaje !== null): ?>
        <p><?= htmlspecialchars($mensaje, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></p>
    <?php endif; ?>

    <?php if ($imagenGuardada !== null): ?>
        <img src="<?= htmlspecialchars('imagen.php?nombre=' . rawurlencode($imagenGuardada), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>" alt="Cartel guardado">
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data" action="subir.php">
        <label for="imagen">Selecciona un archivo:</label>
        <br>
        <input type="file" name="imagen" id="imagen" accept="image/jpeg, image/png, image/webp">
        <br>
        <button type="submit" value="Subir">GUARDAR</button>
    </form>    
    <a href="index.php">Ir al Índice</a> <br>
    <a href="imagen.php">Ir a Imagen</a>
</body>

</html>