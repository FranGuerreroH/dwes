<?php
declare(strict_types=1);

use App\Repository\{ArchivoJson, Catalogo};

App\Soporte\iniciarSesion();

require dirname(__DIR__) . '/vendor/autoload.php';

$catalogo = new Catalogo(new ArchivoJson(dirname(__DIR__) . '/var/libros.json'));

return compact('catalogo');
