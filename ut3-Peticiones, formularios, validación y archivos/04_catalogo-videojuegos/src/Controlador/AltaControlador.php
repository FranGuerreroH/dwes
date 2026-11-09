<?php

declare(strict_types=1);

namespace App\Controlador;

use App\Servicio\Catalogo;
use App\Modelo\Videojuego;
use InvalidArgumentException;
use RuntimeException;

use function App\Soporte\validarVideojuego;
use function App\Soporte\postExcesivo;
use function App\Soporte\inspeccionarCaratula;
use function App\Soporte\prepararDestino;

final class AltaControlador
{
    public function __construct(private Catalogo $catalogo)
    {
    }

    public function mostrar(): void
    {
        $catalogo = $this->catalogo;
        $errores = [];
        $creado = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (postExcesivo()) {
                $errores['general'] = 'El envío completo supera el límite de PHP.';
            } else {
                // Proporcionado. Valida campos y caratula antes de crear o mover.
                $resultado = validarVideojuego($_POST);
                $errores = $resultado['errores'];
                $subida = inspeccionarCaratula($_FILES);

                if ($subida['error'] !== null) {
                    $errores['caratula'] = $subida['error'];
                }

                if ($errores === []) {
                    $datos = $resultado['datos'];

                    try {
                        // COMPLETAR 3. Construir $nuevo con los cinco datos validados.

                        $nuevo = new Videojuego(
                            $datos['titulo'],
                            $datos['estudio'],
                            $datos['horas'],
                            $datos['genero'],
                            $datos['fecha_lanzamiento']
                        );

                        // COMPLETAR 5. Guardar y asociar la carátula si hay archivo.
                        // Al terminar sin errores, agregar $nuevo y asignarlo a $creado.
                        if ($subida['archivo'] !== null) {
                            $archivo = $subida['archivo'];
// llama a prepararDestino($archivo["extension"]). Está en src/Soporte/archivos.php y devuelve nombre, el
// nombre generado con extensión, y ruta, la ruta física de almacenamiento. El directorio y el destino libre
// se comprueban en esa función.
                            $destino = prepararDestino($archivo['extension']);
                            if (move_uploaded_file($archivo['tmp_name'], $destino['ruta']) === false) {
                                $errores['caratula'] = 'No se ha podido mover la carátula a su destino.';
                            } else {
                                $nuevo->cambiarCaratula($destino['nombre']);
                            }                            
                        }

                        $this->catalogo->agregar($nuevo);
                        $creado = $nuevo;
                    } catch (InvalidArgumentException) {
                        $errores['general'] = 'No se ha podido crear el videojuego con esos datos.';
                    } catch (RuntimeException $error) {
                        $errores['caratula'] = $error->getMessage();

                    } catch (InvalidArgumentException) {
                        $errores['general'] = 'No se ha podido crear el videojuego con esos datos.';
                    } catch (RuntimeException $error) {
                        $errores['caratula'] = $error->getMessage();
                    }
                }
            }
        }

        require dirname(__DIR__, 2) . '/vistas/alta.php';
    }
}
