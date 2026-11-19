<?php

declare(strict_types=1);

namespace App\Controlador;

use function App\Soporte\soloMetodos;
use function App\Soporte\redirigir;

final class FavoritosControlador extends Controlador
{
    public function cambiar():void{

        soloMetodos([$_POST]);

        $entrada = $_POST['id'] ?? '';
        // Validar entrada
        $id = is_string($entrada);
        if(!$id){
            http_response_code(400);
            exit;
        }

        if ($this->app['catalogo']->buscarPorId($id) === null) {
            http_response_code(404);
            exit;
        }

        $favoritos = $_SESSION['favoritos'] ?? [];
        if (in_array($id, $favoritos, true)) {
            $favoritos[] = $id;
        }
        
        $_SESSION['favoritos'] = $favoritos;
        redirigir('index.php');
    }
}