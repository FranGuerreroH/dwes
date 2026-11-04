<?php

declare(strict_types=1);

$errores = [];
$esPost = $_SERVER['REQUEST_METHOD'] === 'POST';
$archivo = $_FILES["portada"] ?? null;
$estructuraValida = is_array($archivo)
    && isset($archivo['error'], $archivo['size'])
    && is_int($archivo['error'])
    && is_int($archivo['size'])
    && isset($archivo['tmp_name'])
    && is_string($archivo['tmp_name']);

if ($archivo !== null && !$estructuraValida) {
 $errores['portada'] = 'Entrada no válida.';
}

$titulo = $_POST['titulo'] ?? null;
if ($titulo === null || !is_string($titulo) || trim($titulo) === '') {
    $errores['titulo'] = 'El título es obligatorio.';
}

if ($estructuraValida) {
    if ($archivo['error'] === UPLOAD_ERR_NO_FILE) {
        $archivo = null;
    } elseif ($archivo['error'] !== UPLOAD_ERR_OK) {
        if ($archivo['error'] === UPLOAD_ERR_INI_SIZE) {
            $errores['portada'] = 'El archivo supera el tamaño máximo permitido.';
        } elseif ($archivo['error'] === UPLOAD_ERR_PARTIAL) {
            $errores['portada'] = 'El archivo se subió parcialmente.';
        } else {
            $errores['portada'] = 'No se pudo subir el archivo.';
        }
    } else {
        $tamMax = 2 * 1024 * 1024;
        if ($archivo['size'] <= 0 || $archivo['size'] > $tamMax) {
            $errores['portada'] = 'El archivo debe tener entre 1 byte y 2 MB.';
        } else {
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->file($archivo['tmp_name']);
            $permitidos = [
                'image/jpeg' => 'jpg',
                'image/png' => 'png',
                'image/webp' => 'webp',
            ];
            if ($mime === false || !isset($permitidos[$mime])) {
                $errores['portada'] = 'Formato no permitido.';
            } else {
                $extension = $permitidos[$mime];

                try {
                    $nombre = bin2hex(random_bytes(16))
                     . '.' . $extension;
                     
                    $directorio = __DIR__ . '/../storage/portadas';
                    $destino = $directorio . '/' . $nombre;
                    if (!is_dir($directorio) || !is_writable(
                    $directorio)) {
                    $errores['portada'] =
                    'Almacenamiento no disponible.';
                    }
                    if (file_exists($destino)) {
                    $errores['portada'] =
                    'Nombre ocupado; vuelve a enviar.';
                    }

                } catch (Random\RandomException){
                    $errores['portada'] = 'nombre ocupado, revisalo';
                }
            }
            
        }
    }
}


?>

<h1>Portada</h1> 

<form action="index.php" method="POST" enctype="multipart/form-data">
    <input name="titulo">
    <input name="portada" type="file" accept="image/jpeg, image/png, image/webp">
    <button type="submit">Guardar</button>
</form>

<?php
if ($esPost) {
    echo '<h2>Información del archivo</h2>';
    if ($archivo === null) {
        echo '<p>No se seleccionó ningún archivo.</p>';
    } else {
        echo '<pre>' . htmlspecialchars(print_r($archivo, true), ENT_QUOTES, 'UTF-8') . '</pre>';
    }
}
